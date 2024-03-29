<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\WishlistManagementInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Model\WishlistFactory;

/**
 * Defines the implemented class of the WishlistManagementInterface
 * Class \Aheadworks\MobileAppConnector\Model\WishlistManagement
 */
class WishlistManagement implements WishlistManagementInterface
{
    public const WISHLIST_ITEM_ID = 'wishlist_item_id';
    public const QTY = 'qty';
    public const IMAGE = 'image';
    public const PRODUCT = 'product';

    /**
     * @var WishlistFactory
     */
    protected $wishlistFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var Resolver
     */
    protected $imageResolver;
    /**
     * @var SimpleDataObjectConverter
     */
    protected $simpleDataObjectConverter;

    /**
     * WishlistManagement constructor.
     * @param WishlistFactory $wishlistFactory
     * @param ProductRepositoryInterface $productRepository
     * @param Resolver $imageResolver
     * @param SimpleDataObjectConverter $simpleDataObjectConverter
     */
    public function __construct(
        WishlistFactory $wishlistFactory,
        ProductRepositoryInterface $productRepository,
        Resolver $imageResolver,
        SimpleDataObjectConverter $simpleDataObjectConverter
    ) {
        $this->wishlistFactory = $wishlistFactory;
        $this->productRepository = $productRepository;
        $this->imageResolver = $imageResolver;
        $this->simpleDataObjectConverter = $simpleDataObjectConverter;
    }

    /**
     * Add product to wishlist
     *
     * @throws \Exception
     * @param int $customerId
     * @param int $productId
     * @return string
     */
    public function addProductToWishlist($customerId, $productId)
    {
        try {
            $product = $this->productRepository->getById($productId);
            $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId, true);
            if ($product && $wishlist) {
                $wishlist->addNewItem($product);
                $wishlist->save();
            }
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('We can\'t add the item to Wish List right now.'));
        }
        return true;
    }
    /**
     * Remove product from wish list
     *
     * @throws \Exception
     * @param int $customerId
     * @param int $productId
     * @return string
     */
    public function removeProductFromWishlist($customerId, $productId)
    {
        try {
            $product = $this->productRepository->getById($productId);
            $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId, true);
            $items = $wishlist->getItemCollection();
            if ($product && $wishlist) {
                foreach ($items as $item) {
                    if ($item->getProductId() == $productId) {
                        $item->delete();
                        $wishlist->save();
                    }
                }
            }
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('We can\'t remove the item from Wish List right now.'));
        }
        return true;
    }
    /**
     * Get wishlist for customer
     *
     * @throws \Exception
     * @param int $customerId
     * @return string
     */
    public function getWishlistForCustomer($customerId)
    {
        try {
            $wishlist = $this->wishlistFactory->create();
            $wishlist->loadByCustomerId($customerId, true);
            $collection = $wishlist->getItemCollection();
            $wishlistData = [];
            foreach ($collection as $item) {
                $productInfo = $this->simpleDataObjectConverter->toFlatArray(
                    $item->getProduct(),
                    ProductInterface::class
                );
                $data = [
                    self::WISHLIST_ITEM_ID => $item->getWishlistItemId(),
                    self::QTY => round($item->getQty()),
                    self::IMAGE => $this->imageResolver->getProductImageUrl($item->getProduct(), 'category_page_grid'),
                    self::PRODUCT => $productInfo

                ];
                $wishlistData[] = $data;
            }
            return $wishlistData;
        } catch (\Exception $e) {
            // phpcs:disable Magento2.Exceptions.DirectThrow
            throw new \Exception('We can\'t get Wishlist right now.');
        }
    }
}
