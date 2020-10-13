<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\MostViewedProductInterface;
use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;


/**
 * Defines the implemented class of the MostViewedProductInterface
 * Class \Aheadworks\MobileAppConnector\Model\MostViewedProduct
 */
class MostViewedProduct implements MostViewedProductInterface
{
    const ID = 'id';
    const MIN_PRICE = 'min_price';
    const MAX_PRICE = 'max_price';
    const IMAGE = 'product_image';
    /**
     * @var CollectionFactory
     */
    protected $reportCollectionFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * MostViewedProduct constructor.
     * @param CollectionFactory $reportCollectionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Visibility $productVisibility
     */
    public function __construct(
        CollectionFactory $reportCollectionFactory,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        Visibility $productVisibility
    ) {
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->productVisibility = $productVisibility;
    }

    /**
     * @inheritdoc
     */
    public function getMostViewedProducts($limit, $storeId = null)
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();
            $store = $this->storeManager->getStore();

            $collection = $this->reportCollectionFactory->create()
                ->addAttributeToSelect(
                    'entity_id'
                )->addStoreFilter(
                    $storeId
                )->addViewsCount()->setStoreId(
                    $storeId
                )->setVisibility(
                    $this->productVisibility->getVisibleInSiteIds()
                )->setPageSize($limit);
            $items = $collection->getItems();
            $mostViewedData = [];
            if (count($collection->getData())) {
                foreach ($items as $item) {
                    $product = $this->productRepository->getById($item->getId());
                    $productImageUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getImage();
                    $data = [
                        self::ID => $item->getId(),
                        ProductInterface::NAME => $product->getName(),
                        ProductInterface::TYPE_ID => $item->getTypeId(),
                        ProductInterface::PRICE => $product->getPriceInfo()->getPrice('final_price')->getValue(),
                        self::MIN_PRICE => $this->getMinimumPrice($product),
                        self::MAX_PRICE => $this->getMaximumPrice($product),
                        self::IMAGE=> "TO DO"

                    ];
                    $mostViewedData[] = $data;
                }
                return $mostViewedData;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $product
     * @return mixed
     */
    private function getMinimumPrice($product)
    {
        return $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
    }

    /**
     * @param $product
     * @return mixed
     */
    private function getMaximumPrice($product)
    {
        return $product->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue();
    }
}
