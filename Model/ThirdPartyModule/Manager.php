<?php
namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule;

use Magento\Framework\Module\ModuleListInterface;

/**
 * Class Manager for modules
 *
 */
class Manager
{
    /**
     * Aheadworks DigitalMedia module name
     */
    private const DIGITAL_MEDIA_MODULE_NAME = 'Aheadworks_DigitalMedia';

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

    /**
     * Check if Magento_InventoryInStorePickupQuote module enabled
     *
     * @return bool
     */
    public function isInventoryStoryPickupQuoteModuleEnabled()
    {
        return $this->moduleList->has('Magento_InventoryInStorePickupQuote');
    }

    /**
     * Check if Magento_InventoryGraphQl module enabled
     *
     * @return bool
     */
    public function isInventoryGraphQlEnabled()
    {
        return $this->moduleList->has('Magento_InventoryGraphQl');
    }
}
