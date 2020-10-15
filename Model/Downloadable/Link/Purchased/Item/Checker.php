<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{
    /**
     * Check if purchased item is digital media library item
     *
     * @param PurchasedLinkItemModel $purchasedLinkItem
     * @return bool
     */
    public function isLibraryItem($purchasedLinkItem)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $isLibraryItem = $objectManager->create('\Aheadworks\DigitalMedia\Model\Downloadable\Link\Purchased\Item\Checker');
        return $isLibraryItem->isLibraryItem($purchasedLinkItem);
    }

}
