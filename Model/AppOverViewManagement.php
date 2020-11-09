<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppOverViewRepositoryInterface;
use Exception;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AppOverViewManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class AppOverViewManagement implements AppOverViewRepositoryInterface
{
    const AW_TENANT_ID = 'aw_tenant_id';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function getAppTenantId()
    {
        try {
            $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
            $domain =  $this->getDomainName($baseUrl);
            $data[self::AW_TENANT_ID] = $domain;
            return $data;
        } catch (Exception $e) {
            throw new Exception("We can\'t get tenant id.");
        }
    }

    /**
     * get domain name of third level
     * @param string $tenantId
     * @return string $subdomains|null
     */
    public function getDomainName(string $tenantId)
    {
        $tenantId = parse_url($tenantId);
        $domain = isset($tenantId['host']) ? $tenantId['host'] : '';
        $hostData = explode('.', $domain);
        $subdomains = array_slice($hostData, 0, count($hostData) - 1);
        if (!empty($subdomains[0])) {
            return $subdomains[0];
        } else {
            return null;
        }
    }
}
