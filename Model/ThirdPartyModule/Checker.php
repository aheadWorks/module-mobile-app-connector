<?php
namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule;

use Aheadworks\DigitalMedia\Model\Downloadable\Link\Purchased\Item\Checker as DigitalMediaChecker;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\ProviderFactory;

/**
 * Class Checker
 *
 * @package Aheadworks\MobileAppConnector\Model\ThirdPartyModule
 */
class Checker
{

    /**
     * @var moduleManager
     */
    private $moduleManager;

    /**
     *
     * @var providerFactory
     */
    private $providerFactory;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * Factory constructor
     *
     * @param ProviderFactory $providerFactory
     * @param Manager $moduleManager
     * @param string $instanceName
     */
    public function __construct(
        Manager $moduleManager,
        ProviderFactory $providerFactory,
        $instanceName = DigitalMediaChecker::class
    ) {
        $this->instanceName = $instanceName;
        $this->moduleManager = $moduleManager;
        $this->providerFactory = $providerFactory;
    }

    /**
     * @return bool
     */
    public function isDigitalMediaModuleEnabled()
    {
        $moduleFlag = false;
        if ($this->moduleManager->isDigitalMediaModuleEnabled()) {
            $moduleFlag = true;
        }
        return $moduleFlag;
    }

    /**
     * @param $purchasedLinkItem
     * @return bool
     */
    public function isLibraryItem($purchasedLinkItem)
    {
        $isDownloadable = true;
        if ($this->isDigitalMediaModuleEnabled()) {
            $itemLibrary = $this->providerFactory->create($this->instanceName);
            if ($itemLibrary) {
                if ($itemLibrary->isLibraryItem($purchasedLinkItem)) {
                    $isDownloadable = false;
                }
            }
        }
        return $isDownloadable;
    }
}
