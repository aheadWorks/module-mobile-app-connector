<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface CustomerOrder interface
 * @api
 */
interface CustomerOrderInterface
{
    /**
     * Loads a specified order.
     *
     * @param int $customerId The customerId ID.
     * @param int $id The order ID.
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(int $customerId, int $id);

    /**
     * Lists orders that match specified customer search criteria.
     *
     * @param int $customerId The CustomerId ID.
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(int $customerId);
}
