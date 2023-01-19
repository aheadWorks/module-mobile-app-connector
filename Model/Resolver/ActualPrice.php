<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Resolver;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepository;
use Magento\Msrp\Model\Config as MsrpConfig;

/**
 * Class ActualPrice to display actual price of product
 */
class ActualPrice implements ResolverInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var MsrpConfig
     */
    private $msrpConfig;

    /**
     * ActualPrice constructor.
     *
     * @param ProductRepository $productRepository
     * @param MsrpConfig $msrpConfig
     */
    public function __construct(
        ProductRepository $productRepository,
        MsrpConfig $msrpConfig
    ) {
        $this->productRepository = $productRepository;
        $this->msrpConfig = $msrpConfig;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /* @var Product $product */
        $product = $value['model'];
        $productId = $product->getId();
        $msrpPrice = $this->productRepository->getById($productId)->getMsrp();
        $actualPrice = [
            'status' =>  $this->msrpConfig->isEnabled(),
            'display_actual_price' => $this->msrpConfig->getDisplayActualPriceType() ,
            'default_popup_text_message' => $this->msrpConfig->getExplanationMessage(),
            'default_what_this_text_message' => $this->msrpConfig->getExplanationMessageWhatsThis(),
            'msrp_price'  => $msrpPrice ? $msrpPrice : "0"
        ];
        return $actualPrice;
    }
}
