<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\WishlistManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
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
     */
    public function addProductToWishlist($customerId, $productId)
    {
        if ($productId == null) {
            throw new LocalizedException(__('Invalid product, Please select a valid product'));
        }

        try {
            $product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }

        try {
            $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId, true);
            $wishlist->addNewItem($product);
            $wishlist->save();
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('We can\'t add the item to Wish List right now.'));
        }
        return true;
    }
}
