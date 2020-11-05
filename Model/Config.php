<?php
namespace Aheadworks\MobileAppConnector\Model;

use Magento\Framework\FlagManager;

/**
 * Class Config
 * @package Aheadworks\MobileAppConnector\Model
 */
class Config
{
    /**
     * Configuration path to tenant id
     */
    const AW_TENANT_ID = 'aw_tenant_id';

    /**
     * @var FlagManager
     */
    private $flagManager;

    /**
     * @param FlagManager $flagManager
     */
    public function __construct(
        FlagManager $flagManager
    ) {
        $this->flagManager = $flagManager;
    }

    /**
     * Get tenant id
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->flagManager->getFlagData(self::AW_TENANT_ID);
    }

    /**
     * Set tenant id
     *
     * @param string $tenantId
     * @return $this
     */
    public function setTenantId(string $tenantId)
    {
        $this->flagManager->saveFlag(self::AW_TENANT_ID, $tenantId);
        return $this;
    }
}
