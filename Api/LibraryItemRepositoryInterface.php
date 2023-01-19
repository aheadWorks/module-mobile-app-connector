<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;

/**
 * Interface LibraryItemRepositoryInterface
 */
interface LibraryItemRepositoryInterface
{
    /**
     * Retrieve list of library items for specific customer
     *
     * @param int $customerId
     * @return \Aheadworks\MobileAppConnector\Api\Data\LibraryItemSearchResultsInterface
     */
    public function getList(int $customerId);
}
