<?php
namespace Aheadworks\MobileAppConnector\Model\OverView;

use Aheadworks\MobileAppConnector\Api\OverViewRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\OverView\Config\ConfigHandler as OverViewConfig;
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
     * @return string $subdomains|null
     */
    public function getDomainName($tenantId){

        $tenantId = parse_url($tenantId);
        $domain = isset($tenantId['host']) ? $tenantId['host'] : '';
        $hostData = explode('.', $domain);
        $subdomains = array_slice($hostData, 0, count($hostData) - 2 );
        if(!empty($subdomains[0])){
            return $subdomains[0];
        }
        else{
            return null;
        }
    }
}
