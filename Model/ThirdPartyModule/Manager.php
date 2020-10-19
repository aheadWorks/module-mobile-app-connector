<?php
namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule;

use Magento\Framework\Module\ModuleListInterface;

/**
 * Class Manager
 *
 * @package Aheadworks\MobileAppConnector\Model\ThirdPartyModule
 */
class Manager
{
    /**
     * Aheadworks DigitalMedia module name
     */
    const DIGITAL_MEDIA_MODULE_NAME = 'Aheadworks_DigitalMedia';

    /**
     * @var ModuleListInterface
     */
    private $moduleList;

    /**
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        ModuleListInterface $moduleList
    ) {
        $this->moduleList = $moduleList;
    }

    /**
     * Check if Aheadworks DigitalMedia module enabled
     *
     * @return bool
     */
    public function isDMModuleEnabled()
    {
        return $this->moduleList->has(self::DIGITAL_MEDIA_MODULE_NAME);
    }
}
