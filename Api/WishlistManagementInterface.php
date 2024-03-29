<?php

namespace Aheadworks\MobileAppConnector\Api;

use Exception;

/**
 * Interface WishlistManagementInterface
 * @api
 */
interface WishlistManagementInterface
{
    /**
     * Return true if item Added to wishlist.
     *
     * @param int $customerId
     * @param int $productId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function addProductToWishlist($customerId, $productId);

    /**
     * Return true if item removed from wishlist.
     *
     * @param int $customerId
     * @param int $productId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function removeProductFromWishlist($customerId, $productId);

    /**
     * Return Wishlist items.
     *
     * @param int $customerId
     * @return mixed
     * @throws Exception
     */
    public function getWishlistForCustomer($customerId);
}
