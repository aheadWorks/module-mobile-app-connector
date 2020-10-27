<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Checker\DmLibraryItemFactory;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{

    /**
     * @var DmLibraryItemFactory
     */
    protected $purchasedLinkItemCheckerFactory;

    /**
     * @param DmLibraryItemFactory $purchasedLinkItemCheckerFactory
     */
    public function __construct(
        DmLibraryItemFactory $purchasedLinkItemCheckerFactory
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
        $dmLibraryItem = $this->purchasedLinkItemCheckerFactory->create();
        if ($dmLibraryItem) {
            if ($dmLibraryItem->isLibraryItem($purchasedLinkItem)) {
                $isDownloadable = false;
            }
        }
        return $isDownloadable;
    }
}
