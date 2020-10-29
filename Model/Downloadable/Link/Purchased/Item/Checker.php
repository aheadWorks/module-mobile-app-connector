<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Purchased\Item\Checker\ThirdPartyModuleFactory;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{

    /**
     * @var ThirdPartyModuleFactory
     */
    protected $purchasedLinkItemCheckerFactory;

    /**
     * @param ThirdPartyModuleFactory $purchasedLinkItemCheckerFactory
     */
    public function __construct(
        ThirdPartyModuleFactory $purchasedLinkItemCheckerFactory
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
