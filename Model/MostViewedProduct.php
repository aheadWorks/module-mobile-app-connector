<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\MostViewedProductInterface;
use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Aheadworks\MobileAppConnector\Model\Product\Resolver;

/**
 * Defines the implemented class of the MostViewedProductInterface
 * Class \Aheadworks\MobileAppConnector\Model\MostViewedProduct
 */
class MostViewedProduct implements MostViewedProductInterface
{
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
    protected $productResolver;

    /**
     * MostViewedProduct constructor.
     * @param CollectionFactory $reportCollectionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Visibility $productVisibility
     * @param Resolver $productResolver
     */
    public function __construct(
        CollectionFactory $reportCollectionFactory,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        Visibility $productVisibility,
        Resolver $productResolver
    ) {
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->productVisibility = $productVisibility;
        $this->productResolver = $productResolver;
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
                        Resolver::ID => $item->getId(),
                        ProductInterface::NAME => $item->getName(),
                        ProductInterface::TYPE_ID => $item->getTypeId(),
                        ProductInterface::PRICE => $item->getPrice(),
                        Resolver::MIN_PRICE => $this->productResolver->getMinimumPrice($item),
                        Resolver::MAX_PRICE => $this->productResolver->getMaximumPrice($item),
                        Resolver::FINAL_PRICE => $item->getFinalPrice(),
                        Resolver::IMAGE => $this->productResolver->getProductImageUrl($item, 'category_page_grid')

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
}
