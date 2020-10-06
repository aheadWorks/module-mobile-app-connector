<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\WishlistManagementInterface;
use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Model\WishlistFactory;

/**
 * Defines the implemented class of the WishlistManagementInterface
 */
class WishlistManagement implements WishlistManagementInterface
{
    protected $wishlistRepository;
    protected $productRepository;
    public function __construct(
        WishlistFactory $wishlistRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->wishlistRepository = $wishlistRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Add wishlist item for the customer
     * @param int $customerId
     * @param int $productId
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws Exception
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
            //$product = $this->productRepository->getById($productId);
            $wishlist = $this->wishlistRepository->create()->loadByCustomerId($customerId, true);
            $wishlist->addNewItem($product);
            $wishlist->save();
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('We can\'t add the item to Wish List right now.'));
        }
        return true;
    }
}
