<?php
namespace Aheadworks\MobileAppConnector\Model\OverView;

use Aheadworks\MobileAppConnector\Api\OverViewRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\OverView\Config as OverViewConfig;
/**
 * Class OverViewManagement
 * @package Aheadworks\MobileAppConnector\Model\OverView
 */
class OverViewManagement implements OverViewRepositoryInterface
{
    /**
     * @var OverViewConfig
     */
    private $overviewconfig;

    /**
     * @param OverviewConfig $overviewconfig
     */
    public function __construct(
        OverviewConfig $overviewconfig
        
    ) {
        $this->overviewconfig = $overviewconfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantId()
    {
        try {
            $tenantId = $this->overviewconfig->getTenantId();
            if(isset($tenantId) && $tenantId!=''){
               $domain =  $this->getDomainName($tenantId);
            }
            $data = [
                OverViewConfig::AW_TENANT_ID => $domain
            ];
            $overViewData[] = $data;
            return $overViewData;
        } catch (\Exception $e) {
            throw new \Exception('We can\'t get tenant id.');
        }
    }

    /**
     * get domain name of third level
     * @param string $tenantId 
     * @return string $domainname
     */
    public function getDomainName($tenantId){
        $tenantId = parse_url($tenantId);
        $domain = isset($tenantId['host']) ? $tenantId['host'] : '';
        $hostData = explode('.', $domain);
        if(isset($hostData[1])){ 
            return $hostData[1];
        }
        else{
            return 'error no domain';
        }
    }
}
