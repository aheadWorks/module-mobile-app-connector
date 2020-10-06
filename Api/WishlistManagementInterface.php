<?php
namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface WishlistManagementInterface
 * @api
 */
interface WishlistManagementInterface
{
    /**
     * Return Added wishlist item.
     *
     * @param int $customerId
     * @param int $productId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function addProductToWishlist($customerId, $productId);
}
