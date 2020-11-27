<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\BestSellingProductInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Defines the implemented class of the BestSellingProductInterface
 * Class \Aheadworks\MobileAppConnector\Model\BestSellingProduct
 */
class BestSellingProduct implements BestSellingProductInterface
{
    const ID = 'id';
    const MIN_PRICE = 'min_price';
    const MAX_PRICE = 'max_price';
    const FINAL_PRICE = 'final_price';
    const IMAGE = 'product_image';
    const QTY_ORDERD ='qty_ordered';
    const PERIOD = 'period';

    /**
     * @var CollectionFactory
     */
    protected $bestSellersCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Resolver
     */
    protected $imageResolver;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * BestSellersProduct constructor.
     * @param CollectionFactory $bestSellersCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Resolver $imageResolver
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        CollectionFactory $bestSellersCollectionFactory,
        StoreManagerInterface $storeManager,
        Resolver $imageResolver,
        ProductRepositoryInterface $productRepository
    ) {
        $this->bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->storeManager = $storeManager;
        $this->imageResolver = $imageResolver;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function getBestSellingProducts($period, $storeId = null)
    {
        try {
            $bestSellerProductCollection = $this->bestSellersCollectionFactory->create()
            ->addStoreFilter(
                $storeId
            )->setPeriod(
                $period);
            $bestSellerData = [];
            foreach ($bestSellerProductCollection as $product) {
                $item = $this->productRepository->getById($product->getProductId());
                
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
                    
                $bestSellerData[] = $data;
            }
            return $bestSellerData;
        } catch (Exception $e) {
            $e->getMessage();
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
