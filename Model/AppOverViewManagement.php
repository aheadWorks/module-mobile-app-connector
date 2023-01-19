<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppOverViewRepositoryInterface;
use Exception;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class for app overview management
 */
class AppOverViewManagement implements AppOverViewRepositoryInterface
{
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
     * Get app tenant id
     *
     * @throws LocalizedException
     * @throws Exception
     */
    public function getAppTenantId()
    {
        try {
            $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
            return $this->getDomainName($baseUrl);
        } catch (Exception $e) {
            throw new LocalizedException(__("We can\'t get tenant id."));
        }
    }

    /**
     * Get domain name of third level
     *
     * @param string $tenantId
     * @return string $subdomains|null
     */
    private function getDomainName(string $tenantId)
    {
         // phpcs:ignore Magento2.Functions.DiscouragedFunction
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
