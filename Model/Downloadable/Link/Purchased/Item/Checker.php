<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Checker\ChekerFactory;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{

    /**
     * @var ChekerFactory
     */
    protected $purchasedLinkItemCheckerFactory;

    /**
     * @param ChekerFactory $purchasedLinkItemCheckerFactory
     */
    public function __construct(
        ChekerFactory $purchasedLinkItemCheckerFactory
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
        $isLibraryItem = $this->purchasedLinkItemCheckerFactory->create();
        if ($isLibraryItem) {
            if ($isLibraryItem->isLibraryItem($purchasedLinkItem)) {
                $isDownloadable = false;
            }
        }
        return $isDownloadable;
    }
}
