<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\WishlistManagementInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory;
use Magento\Wishlist\Model\Wishlist;
use Magento\Wishlist\Model\WishlistFactory;

/**
 * Defines the implemented class of the WishlistManagementInterface
 * Class \Aheadworks\MobileAppConnector\Model\WishlistManagement
 */
class WishlistManagement implements WishlistManagementInterface
{
    const WISHLIST_ITEM_ID = 'wishlist_item_id';
    const QTY = 'qty';
    const IMAGE = 'image';
    const PRODUCT = 'product';

    /**
     * @var WishlistFactory
     */
    protected $wishlistFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var CollectionFactory
     */
    protected $wishlistItem;
    /**
     * @var Resolver
     */
    protected $imageResolver;
    /**
     * @var SimpleDataObjectConverter
     */
    protected $simpleDataObjectConverter;
    /**
     * @var Wishlist
     */
    protected $wishlist;

    /**
     * WishlistManagement constructor.
     * @param WishlistFactory $wishlistFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $wishlistItem
     * @param Resolver $imageResolver
     * @param SimpleDataObjectConverter $simpleDataObjectConverter
     * @param Wishlist $wishlist
     */
    public function __construct(
        WishlistFactory $wishlistFactory,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $wishlistItem,
        Resolver $imageResolver,
        SimpleDataObjectConverter $simpleDataObjectConverter,
        Wishlist $wishlist
    ) {
        $this->wishlistFactory = $wishlistFactory;
        $this->productRepository = $productRepository;
        $this->wishlistItem= $wishlistItem;
        $this->imageResolver = $imageResolver;
        $this->simpleDataObjectConverter = $simpleDataObjectConverter;
        $this->wishlist = $wishlist;
    }

    /**
     * @inheritdoc
     * @throws \Exception
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
     * @inheritdoc
     * @throws \Exception
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
     * @inheritdoc
     * @throws \Exception
     */
    public function getWishlistForCustomer($customerId)
    {
        try {
            $collection =
                $this->wishlist->loadByCustomerId($customerId, true)
                    ->getItemCollection();
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
            return false;
        }
    }
}
