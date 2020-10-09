<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\WishlistManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory;
use Magento\Wishlist\Model\WishlistFactory;

/**
 * Defines the implemented class of the WishlistManagementInterface
 * Class \Aheadworks\MobileAppConnector\Model\WishlistManagement
 */
class WishlistManagement implements WishlistManagementInterface
{
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
    protected $wishlistCollectionFactory;

    /**
     * WishlistManagement constructor.
     * @param WishlistFactory $wishlistFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $wishlistCollectionFactory
     */
    public function __construct(
        WishlistFactory $wishlistFactory,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $wishlistCollectionFactory
    ) {
        $this->wishlistFactory = $wishlistFactory;
        $this->productRepository = $productRepository;
        $this->wishlistCollectionFactory= $wishlistCollectionFactory;
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
                $this->wishlistCollectionFactory->create()
                    ->addCustomerIdFilter($customerId);
            $wishlistData = [];
            foreach ($collection as $item) {
                $productInfo = $item->getProduct()->getData();
                $data = [
                    "wishlist_item_id" => $item->getWishlistItemId(),
                    "qty"              => round($item->getQty()),
                    "product" => $productInfo

                ];
                $wishlistData[] = $data;
            }
            return $wishlistData;
        } catch (\Exception $e) {
            return false;
        }
    }
}
