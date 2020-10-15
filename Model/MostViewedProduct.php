<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\MostViewedProductInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
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
    const FINAL_PRICE = 'final_price';
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
     * @var Resolver
     */
    protected $imageResolver;

    /**
     * MostViewedProduct constructor.
     * @param CollectionFactory $reportCollectionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Visibility $productVisibility
     * @param Resolver $imageResolver
     */
    public function __construct(
        CollectionFactory $reportCollectionFactory,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        Visibility $productVisibility,
        Resolver $imageResolver
    ) {
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->productVisibility = $productVisibility;
        $this->imageResolver = $imageResolver;
    }

    /**
     * @inheritdoc
     */
    public function getMostViewedProducts($limit, $storeId = null)
    {
        try {
            $collection = $this->reportCollectionFactory->create()
                ->addAttributeToSelect(
                    '*'
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
                    $data = [
                        self::ID => $item->getId(),
                        ProductInterface::NAME => $item->getName(),
                        ProductInterface::TYPE_ID => $item->getTypeId(),
                        ProductInterface::PRICE => $item->getPrice(),
                        self::MIN_PRICE => $this->getMinimumPrice($item),
                        self::MAX_PRICE => $this->getMaximumPrice($item),
                        self::FINAL_PRICE => $item->getFinalPrice(),
                        self::IMAGE => $this->imageResolver->getProductImageUrl($item, 'category_page_grid')

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
     * Return product min price
     * @param ProductInterface $item
     * @return double
     */
    private function getMinimumPrice($item)
    {
        return $item->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
    }

    /**
     * Return product max price
     * @param ProductInterface $item
     * @return double
     */
    private function getMaximumPrice($item)
    {
        return $item->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue();
    }
}
