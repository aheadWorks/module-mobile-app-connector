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
use Magento\Framework\Exception\InputException;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product\Visibility;

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
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Resolver $imageResolver
     * @param LinkFactory $linkFactory
     * @param CollectionFactory $productCollectionFactory
     * @param Visibility $productVisibility
     * @param StoreManagerInterface $storeManager    
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        Resolver $imageResolver,
        LinkFactory $linkFactory,
        CollectionFactory $productCollectionFactory,
        Visibility $productVisibility,
        StoreManagerInterface $storeManager
    ) {
        $this->productRepository = $productRepository;
        $this->imageResolver = $imageResolver;
        $this->linkFactory = $linkFactory;
        $this->productCollectionFactory = $productCollectionFactory; 
        $this->storeManager = $storeManager;
        $this->productVisibility = $productVisibility;
    }

    /**
     * @inheritdoc
     */
    public function getRelatedProducts($customerId, $sku, $storeId = null)
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
            $collection->setProduct($product);
            $relatedProducts = $collection->getItems();
            $productIds =[];
            foreach ($relatedProducts as $key => $relatedProduct) {
                $productIds[] = $relatedProduct->getId();
            }
            $productCollection = $this->productCollectionFactory->create()
                ->addAttributeToSelect(
                    '*'
                )->addStoreFilter(
                    $storeId
                )->setVisibility(
                    $this->productVisibility->getVisibleInSiteIds()
                )->addFieldToFilter('entity_id', ['in' =>$productIds])
                ->addAttributeToFilter(
                    'status',
                    array('eq' => \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
                );

            $items = $productCollection->getItems();
            $relatedProductsData = [];
            foreach ($items as $item) {
                $data = [
                        self::ID => $item->getId(),
                        ProductInterface::SKU => $item->getSku(),
                        ProductInterface::NAME => $item->getName(),
                        ProductInterface::PRICE => $item->getPrice(),
                        ProductInterface::TYPE_ID => $item->getTypeId(),
                        self::MIN_PRICE => $this->getMinimumPrice($item),
                        self::MAX_PRICE => $this->getMaximumPrice($item),
                        self::FINAL_PRICE => $item->getFinalPrice(),
                        self::IMAGE => $this->getProductImageUrl($item),

                ];
                $relatedProductsData []= $data;
            }
            return $relatedProductsData;
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t get Related product right now.'));
        }
    }

    /**
     * Return ptoduct link type
     * @return int
     */
    protected function getLinkType(): int
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
