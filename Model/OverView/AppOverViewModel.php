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
     * @param FlagFactory $flagFactory
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Processing save overview data
     *
     * @return $this
     */
    public function save($data)
    {
       $this->config->setTenantId($data['aw_tenant_id']);
       return $this;
    }
}
