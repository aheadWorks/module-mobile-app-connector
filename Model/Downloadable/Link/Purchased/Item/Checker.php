<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;
use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{
    /**
     * @param purchasedLinkItemCheckerFactory $purchasedLinkItemCheckerFactory
     */
    public function __construct(
        Factory $purchasedLinkItemCheckerFactory
    ) {
        $this->purchasedLinkItemCheckerFactory = $purchasedLinkItemCheckerFactory;
    }

    /**
     *@param PurchasedLinkItemModel $purchasedLinkItem
     * @return bool
     */
    public function isLibraryItem($purchasedLinkItem)
    {
        $isDownloadable = true;
        $libraryItemObj = $this->purchasedLinkItemCheckerFactory->create();
        if ($libraryItemObj) {
            if ($libraryItemObj->isLibraryItem($purchasedLinkItem)) {
                $isDownloadable = false;
            }
        }
        return $isDownloadable;
    }
}
