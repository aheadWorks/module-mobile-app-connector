<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\RelatedProductsRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Link;
use Magento\Catalog\Model\Product\LinkFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Exception\InputException;

/**
 * Class RelatedProductsManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class RelatedProductsManagement implements RelatedProductsRepositoryInterface
{
    const ID = 'id';
    const MIN_PRICE = 'min_price';
    const MAX_PRICE = 'max_price';
    const FINAL_PRICE = 'final_price';
    const IMAGE = 'product_image';

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Resolver
     */
    protected $imageResolver;

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
     * @param Resolver $imageResolver
     * @param LinkFactory $linkFactory
     * @param Visibility $productVisibility
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        Resolver $imageResolver,
        LinkFactory $linkFactory,
        Visibility $productVisibility
    ) {
        $this->productRepository = $productRepository;
        $this->imageResolver = $imageResolver;
        $this->linkFactory = $linkFactory;
        $this->productVisibility = $productVisibility;
    }

    /**
     * @inheritdoc
     */
    public function getRelatedProducts($customerId, $sku)
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
            $collection->addAttributeToSelect('*');
            $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
            $collection->setProduct($product);
            $relatedProducts = $collection->getItems();
            $productsData = [];
            foreach ($relatedProducts as $relatedProduct) {
                $data = [
                        self::ID => $relatedProduct->getId(),
                        ProductInterface::SKU => $relatedProduct->getSku(),
                        ProductInterface::NAME => $relatedProduct->getName(),
                        ProductInterface::PRICE => $relatedProduct->getPrice(),
                        ProductInterface::TYPE_ID => $relatedProduct->getTypeId(),
                        self::MIN_PRICE => $this->getMinimumPrice($relatedProduct),
                        self::MAX_PRICE => $this->getMaximumPrice($relatedProduct),
                        self::FINAL_PRICE => $relatedProduct->getFinalPrice(),
                        self::IMAGE => $this->getProductImageUrl($relatedProduct),

                ];
                $productsData[] = $data;
            }
            return $productsData;
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t get Related product right now.'));
        }
    }

    /**
     * product link type
     * @return int
     */
    private function getLinkType(): int
    {
        return Link::LINK_TYPE_RELATED;
    }

    /**
     * @param ProductInterface $relatedProduct
     * @return string $image
     */
    protected function getProductImageUrl($relatedProduct)
    {
        return $this->imageResolver->getProductImageUrl($relatedProduct, 'category_page_grid');
    }

    /**
     * Return product min price
     * @param ProductInterface $relatedProduct
     * @return double
     */
    private function getMinimumPrice($relatedProduct)
    {
        return $relatedProduct->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
    }

    /**
     * Return product max price
     * @param ProductInterface $relatedProduct
     * @return double
     */
    private function getMaximumPrice($relatedProduct)
    {
        return $relatedProduct->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue();
    }
}
