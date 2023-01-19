<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Resolver;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Aheadworks\MobileAppConnector\Model\Service\Product\Inventory as ProductInventory;

/**
 * Class StockStatusProvider provides stock status of product
 */
class StockStatusProvider implements ResolverInterface
{
    /**
     * @var ProductInventory
     */
    private $productInventory;

    /**
     * StockStatusProvider constructor.
     *
     * @param ProductInventory $productInventory
     */
    public function __construct(ProductInventory $productInventory)
    {
        $this->productInventory = $productInventory;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return string
     * @throws LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): string
    {
        if (!array_key_exists('model', $value) || !$value['model'] instanceof ProductInterface) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        /* @var $product ProductInterface */
        $product = $value['model'];

        return $this->productInventory->isProductInStock($product) ? 'IN_STOCK' : 'OUT_OF_STOCK';
    }
}
