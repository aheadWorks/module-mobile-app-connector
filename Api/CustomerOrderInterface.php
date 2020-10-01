<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;

/**
 * CustomerOrder interface
 * @api
 */
interface CustomerOrderInterface
{
    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ORDER_ID = 'entity_id';
    const ORDER_INCREMENT_ID = 'increment_id';
    const ORDER_CREATED_AT = 'created_at';
    const ORDER_GRAND_TOTAL = 'grand_total';
    const ORDER_STATUS = 'status';
    const ORDER_SHIP_TO = 'ship_to';
    /**
     * Loads a specified order.
     *
     * @param int $id The order ID.
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     */
    public function get(int $id);

    /**
     * Returns orders data to user
     *
     * @param int $customerId The CustomerId ID.
     * @return \Magento\Sales\Api\Data\OrderSearchResultInterface Order search result interface.
     */
    public function getList(int $customerId);
}
