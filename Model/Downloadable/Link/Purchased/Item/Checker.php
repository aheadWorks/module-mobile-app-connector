<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\DigitalMedia\Purchased\Item\Checker\CheckerFactory;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{

    /**
     * @var CheckerFactory
     */
    protected $purchasedLinkItemCheckerFactory;

    /**
     * @param CheckerFactory $purchasedLinkItemCheckerFactory
     */
    public function __construct(
        CheckerFactory $purchasedLinkItemCheckerFactory
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
        $thirdPartyPurchasedLinkItemChecker  = $this->purchasedLinkItemCheckerFactory->create();
        if ($thirdPartyPurchasedLinkItemChecker) {
            if ($thirdPartyPurchasedLinkItemChecker->isLibraryItem($purchasedLinkItem)) {
                $isDownloadable = false;
            }
        }
        return $isDownloadable;
    }
}
