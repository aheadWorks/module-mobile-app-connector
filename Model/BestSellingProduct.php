<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\BestSellingProductInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Aheadworks\MobileAppConnector\Model\Product\Resolver as ProductResolver;
use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Defines the implemented class of the BestSellingProductInterface
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * BestSellingProduct constructor.
     *
     * @param CollectionFactory $bestSellersCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Resolver $imageResolver
     * @param ProductResolver $productResolver
     * @param ProductRepositoryInterface $productRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $bestSellersCollectionFactory,
        StoreManagerInterface $storeManager,
        Resolver $imageResolver,
        ProductResolver $productResolver,
        ProductRepositoryInterface $productRepository,
        LoggerInterface $logger
    ) {
        $this->bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->storeManager = $storeManager;
        $this->imageResolver = $imageResolver;
        $this->productResolver = $productResolver;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function getBestSellingProducts($period, $storeId = null): array
    {
        $this->validatePeriod($period);
        try {
            $bestSellerProductCollection = $this->bestSellersCollectionFactory->create()
                ->addStoreFilter($storeId)
                ->setPeriod($period);
            $bestSellerData = [];
            foreach ($bestSellerProductCollection as $product) {
                try {
                    $item = $this->productRepository->getById($product->getProductId());
                } catch (NoSuchEntityException $ex) {
                    $this->logger->info(
                        "MobileAppConnector Best Selling Products Info: Product with ID " . $product->getProductId() .
                        " not found"
                    );
                    continue;
                }

                $data = [
                    ProductResolver::ID => $item->getId(),
                    ProductInterface::NAME => $item->getName(),
                    ProductInterface::TYPE_ID => $item->getTypeId(),
                    ProductInterface::PRICE => $item->getPrice(),
                    ProductResolver::MIN_PRICE => $this->productResolver->getMinimumPrice($item),
                    ProductResolver::MAX_PRICE => $this->productResolver->getMaximumPrice($item),
                    ProductResolver::FINAL_PRICE => $item->getFinalPrice(),
                    ProductResolver::IMAGE => $this->imageResolver->getProductImageUrl(
                        $item,
                        'category_page_grid'
                    )
                ];

                $bestSellerData[] = $data;
            }
            return $bestSellerData;
        } catch (Exception $e) {
            $this->logger->error(
                "MobileAppConnector Best Selling Products Exception - " .
                $e->getMessage() . ': ' . $e->getTraceAsString()
            );
            throw new Exception("There is something wrong!");
        }
    }

    /**
     * Validate input period
     *
     * @param string $period
     * @throws Exception
     * @return void
     */
    public function validatePeriod($period): void
    {
        $allowedPeriods = ['day','month','year'];
        if (!in_array($period, $allowedPeriods)) {
            throw new Exception('Accepted period values are day,month and year');
        }
    }
}
