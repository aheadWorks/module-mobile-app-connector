<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\MostViewedRepositoryInterface;
use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Defines the implemented class of the MostViewedRepositoryInterface
 * Class \Aheadworks\MobileAppConnector\Model\MostViewedRepository
 */
class MostViewedRepository implements MostViewedRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $reportCollectionFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * MostViewedRepository constructor.
     * @param CollectionFactory $reportCollectionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CollectionFactory $reportCollectionFactory,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productRepositoryInterface = $productRepository;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getMostViewedProducts($limit)
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();

            $collection = $this->reportCollectionFactory->create()
                ->addAttributeToSelect(
                    '*'
                )->addViewsCount()->setStoreId(
                    $storeId
                )->addStoreFilter(
                    $storeId
                )->setPageSize($limit);
            $items = $collection->getItems();

            if (count($collection->getData())) {
                foreach ($items as $item) {
                    $product = $this->productRepositoryInterface->getById($item->getId());
                    $data = [
                        "product_id" => $item->getId(),
                        "product_name" => $item->getName(),
                        "product_type_id" => $item->getTypeId(),
                        "final_price" => $product->getPriceInfo()->getPrice('final_price')->getValue(),
                        "minimul_price" => $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue(),
                        "maximul_price" => $product->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue(),
                        "product_image" => $product->getData('image'),
                        "product_thumbnail" => $product->getData('thumbnail'),
                        "product_small_image" => $product->getData('small_image')

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
