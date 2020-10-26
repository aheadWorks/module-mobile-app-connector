<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\WishlistManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
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
     * WishlistManagement constructor.
     * @param WishlistFactory $wishlistFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        WishlistFactory $wishlistFactory,
        ProductRepositoryInterface $productRepository
    ) {
        $this->wishlistFactory = $wishlistFactory;
        $this->productRepository = $productRepository;
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
}
