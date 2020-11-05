<?php
namespace Aheadworks\MobileAppConnector\Model\OverView;

use Aheadworks\MobileAppConnector\Model\Config;

/**
 * Class AppOverViewModel
 * @package Aheadworks\MobileAppConnector\Model\OverView
 */
class AppOverViewModel
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Processing save app overview data
     *
     * @param $data
     * @return $this
     */
    public function save($data)
    {
        $this->config->setTenantId($data[Config::AW_TENANT_ID]);
        return $this;
    }
}
