<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\RelatedProductsRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Link;
use Magento\Catalog\Model\Product\LinkFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Exception\InputException;
use Aheadworks\MobileAppConnector\Model\Product\Resolver;

/**
 * Class for related products management
 */
class RelatedProductsManagement implements RelatedProductsRepositoryInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Resolver
     */
    protected $productResolver;

    /**
     * @var LinkFactory
     */
    private $linkFactory;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Resolver $productResolver
     * @param LinkFactory $linkFactory
     * @param Visibility $productVisibility
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        Resolver $productResolver,
        LinkFactory $linkFactory,
        Visibility $productVisibility
    ) {
        $this->productRepository = $productRepository;
        $this->productResolver = $productResolver;
        $this->linkFactory = $linkFactory;
        $this->productVisibility = $productVisibility;
    }

    /**
     * Get related products
     *
     * @param string $sku
     * @param int $storeId
     * @return array
     */
    public function getRelatedProducts($sku, $storeId = null)
    {
        if (empty($sku) || !isset($sku)) {
            throw new InputException(__('Sku required'));
        }
        try {
            $product =  $this->productRepository->get($sku);
            $linkType = $this->getLinkType();
            $link = $this->linkFactory->create(['data' => ['link_type_id' => $linkType]]);
            $collection = $link->getProductCollection();
            $collection->setIsStrongMode();
            $collection->addAttributeToSelect('*')
                ->addStoreFilter(
                    $storeId
                );
            $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
            $collection->setProduct($product);
            $relatedProducts = $collection->getItems();
            $productsData = [];
            foreach ($relatedProducts as $relatedProduct) {
                $data = [
                    Resolver::ID => $relatedProduct->getId(),
                    ProductInterface::SKU => $relatedProduct->getSku(),
                    ProductInterface::NAME => $relatedProduct->getName(),
                    ProductInterface::PRICE => $relatedProduct->getPrice(),
                    ProductInterface::TYPE_ID => $relatedProduct->getTypeId(),
                    Resolver::MIN_PRICE => $this->productResolver->getMinimumPrice($relatedProduct),
                    Resolver::MAX_PRICE => $this->productResolver->getMaximumPrice($relatedProduct),
                    Resolver::FINAL_PRICE => $relatedProduct->getFinalPrice(),
                    Resolver::IMAGE => $this->productResolver->getProductImageUrl($relatedProduct),

                ];
                $productsData[] = $data;
            }
            return $productsData;
        } catch (\Exception $e) {
            // phpcs:disable Magento2.Exceptions.DirectThrow
            throw new \Exception(__('We can\'t get Related product right now.'));
        }
    }

    /**
     * Product link type
     *
     * @return int
     */
    private function getLinkType(): int
    {
        return Link::LINK_TYPE_RELATED;
    }
}
