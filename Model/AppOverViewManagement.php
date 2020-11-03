<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppOverViewRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\Config as OverViewConfig;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AppOverViewManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class AppOverViewManagement implements AppOverViewRepositoryInterface
{
    /**
     * @var OverViewConfig
     */
    private $overviewconfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param OverviewConfig $overviewconfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        OverviewConfig $overviewconfig,
        StoreManagerInterface $storeManager
    ) {
        $this->overviewconfig = $overviewconfig;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getTenantId()
    {
        try {
            $tenantId = $this->overviewconfig->getTenantId();
            if (empty($tenantId)) {
                $tenantId = $this->storeManager->getStore()->getBaseUrl();
            }
            $domain =  $this->getDomainName($tenantId);
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
    public function getDomainName($tenantId)
    {
        $tenantId = parse_url($tenantId);
        $domain = isset($tenantId['host']) ? $tenantId['host'] : '';
        $hostData = explode('.', $domain);
        $subdomains = array_slice($hostData, 0, count($hostData) - 2);
        if (!empty($subdomains[0])) {
            return $subdomains[0];
        } else {
            return null;
        }
    }
}
