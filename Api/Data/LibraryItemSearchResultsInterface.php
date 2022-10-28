<?php
namespace Aheadworks\MobileAppConnector\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface LibraryItemSearchResultsInterface
 *
 * @package Aheadworks\MobileAppConnector\Api\Data
 */
interface LibraryItemSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get library items list
     *
     * @return \Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface[]
     */
    public function getItems();

    /**
     * Set library items list
     *
     * @param \Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
