<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\BestSellingProductInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Aheadworks\MobileAppConnector\Model\Product\Resolver as ProductResolver;
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
     * @var ProductResolver
     */
    protected $productResolver;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * BestSellersProduct constructor.
     * @param CollectionFactory $bestSellersCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Resolver $imageResolver
     * @param ProductResolver $productResolver
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        CollectionFactory $bestSellersCollectionFactory,
        StoreManagerInterface $storeManager,
        Resolver $imageResolver,
        ProductResolver $productResolver,
        ProductRepositoryInterface $productRepository
    ) {
        $this->bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->storeManager = $storeManager;
        $this->imageResolver = $imageResolver;
        $this->productResolver = $productResolver;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function getBestSellingProducts($period, $storeId = null)
    {
        $this->validatePeriod($period);
        try {
            $bestSellerProductCollection = $this->bestSellersCollectionFactory->create()
            ->addStoreFilter(
                $storeId
            )->setPeriod(
                $period
            );
            $bestSellerData = [];
            foreach ($bestSellerProductCollection as $product) {
                $item = $this->productRepository->getById($product->getProductId());

                $data = [
                            ProductResolver::ID => $item->getId(),
                            ProductInterface::NAME => $item->getName(),
                            ProductInterface::TYPE_ID => $item->getTypeId(),
                            ProductInterface::PRICE => $item->getPrice(),
                            ProductResolver::MIN_PRICE => $this->productResolver->getMinimumPrice($item),
                            ProductResolver::MAX_PRICE => $this->productResolver->getMaximumPrice($item),
                            ProductResolver::FINAL_PRICE => $item->getFinalPrice(),
                            ProductResolver::IMAGE => $this->imageResolver->getProductImageUrl($item, 'category_page_grid')

                        ];

                $bestSellerData[] = $data;
            }
            return $bestSellerData;
        } catch (Exception $e) {
            throw new Exception("There is something wrong!");
        }
    }

    /**
     * Validate input period
     * @param string $period
     * @throws Exception
     */
    public function validatePeriod($period)
    {
        $allowedPeriods = ['day','month','year'];
        if (!in_array($period, $allowedPeriods)) {
            throw new Exception('Accepted period values are day,month and year');
        }
    }
}
