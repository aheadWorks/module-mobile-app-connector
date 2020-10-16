<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Manager;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Checker\Factory as ItemCheckerFactory;
/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Checker
{
    
    /**
     * @var moduleManager
     */
    private $moduleManager;

    /**
     * @var moduleManager
     */
    private $itemCheckerFactory;

    /**
     * @param Manager $moduleManager
     */
    public function __construct(
        Manager $moduleManager,
        ItemCheckerFactory $temCheckerFactory
    )
    {
        $this->moduleManager = $moduleManager;
        $this->itemCheckerFactory = $temCheckerFactory;
    }

    /**
     * Check if purchased item is digital media library item
     *
     * @param purchasedLinkItem $purchasedLinkItem
     * @return bool
     */
    public function isLibraryItem($purchasedLinkItem)
    {
        return $this->itemCheckerFactory->create($purchasedLinkItem);
    }

    /**
     * Retrieve item is downloadable
     *
     * @param LibraryItemInterface $item
     * @return bool
     */
    public function getIsDownloadable($item){

        $isDownloadble = true;
        if($this->moduleManager->isDigitalMediaModuleEnabled()){
            if($this->isLibraryItem($item)){
               $isDownloadble = false;
            }
        }
        return $isDownloadble;
    }

}
