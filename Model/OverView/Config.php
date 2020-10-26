<?php
namespace Aheadworks\MobileAppConnector\Model\OverView;

use Aheadworks\MobileAppConnector\Model\OverView\Flag;
use Aheadworks\MobileAppConnector\Model\OverView\FlagFactory;

/**
 * Class Config
 * @package Aheadworks\MobileAppConnector\Model\OverView
 */
class Config
{
    /**
     * Configuration path to tenant id
     */
    const AW_TENANT_ID = 'aw_tenant_id';

    /**
     * @var Flag
     */
    private $flag;

    /**
     * @param FlagFactory $flagFactory
     */
    public function __construct(
        FlagFactory $flagFactory
    ) {
        $this->flag = $flagFactory->create();
    }

    /**
     * Get flag data
     *
     * @param string $param
     * @return array
     */
    private function getFlagData($param)
    {
        $this->flag
            ->unsetData()
            ->setOverViewFlagCode($param)
            ->loadSelf();

        return $this->flag->getFlagData();
    }

    /**
     * Set flag data
     *
     * @param string $param
     * @param mixed $value
     * @return $this
     */
    private function setFlagData($param, $value)
    {
        $this->flag
            ->unsetData()
            ->setOverViewFlagCode($param)
            ->loadSelf()
            ->setFlagData($value)
            ->save();

        return $this;
    }

    /**
     * Get tenant id
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->getFlagData(self::AW_TENANT_ID);
    }

    /**
     * Set tenant id
     *
     * @param string $tenantId
     * @return $this
     */
    public function setTenantId($tenantId)
    {
        $this->setFlagData(self::AW_TENANT_ID, $tenantId);
        return $this;
    }
}
