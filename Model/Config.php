<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config of system settings
 */
class Config
{
    public const XML_PATH_PRODUCTION_MODE_ENABLED = 'aw_mac/aw_mac_setting/is_production_mode_enabled';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Is Production module enabled
     *
     * @return bool
     */
    public function isProductionModeEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_PRODUCTION_MODE_ENABLED,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
    }
}
