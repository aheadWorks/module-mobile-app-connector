<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\MostViewedProductInterface;
use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;


/**
 * Defines the implemented class of the MostViewedProductInterface
 * Class \Aheadworks\MobileAppConnector\Model\MostViewedProduct
 */
class MostViewedProduct implements MostViewedProductInterface
{
    const ID = 'id';
    const MINIMUL_PRICE = 'minimul_price';
    const MAXIMUL_PRICE = 'maximul_price';
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
     * MostViewedProduct constructor.
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
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function getMostViewedProducts($limit)
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();
            $store = $this->storeManager->getStore();

            $collection = $this->reportCollectionFactory->create()
                ->addAttributeToSelect(
                    '*'
                )->addViewsCount()->setStoreId(
                    $storeId
                )->addStoreFilter(
                    $storeId
                )->setPageSize($limit);
            $items = $collection->getItems();
            $mostViewedData = [];
            if (count($collection->getData())) {
                foreach ($items as $item) {
                    $product = $this->productRepository->getById($item->getId());
                    $productImageUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getImage();
                    $data = [
                        self::ID => $item->getId(),
                        ProductInterface::NAME => $item->getName(),
                        ProductInterface::TYPE_ID => $item->getTypeId(),
                        ProductInterface::PRICE => $product->getPriceInfo()->getPrice('final_price')->getValue(),
                        self::MINIMUL_PRICE => $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue(),
                        self::MAXIMUL_PRICE => $product->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue(),
                        self::IMAGE=> $productImageUrl

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
