<?php
namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\ThirdPartyModule
 */
class Checker
{
    /**
     * checkerFactory
     */
    private $libraryItemObj;

    /**
     * @param Factory $checkerFactory
     */
    public function __construct(
        Factory $checkerFactory
    ) {
        $this->checkerFactory = $checkerFactory;
        $this->libraryItemObj = $checkerFactory->create();
    }

    /**
     * @param $purchasedLinkItem
     * @return bool
     */
    public function isLibraryItem($purchasedLinkItem)
    {
        $isDownloadable = true;
        if ($this->libraryItemObj) {
            if ($this->libraryItemObj->isLibraryItem($purchasedLinkItem)) {
                $isDownloadable = false;
            }
        }
        return $isDownloadable;
    }
}
