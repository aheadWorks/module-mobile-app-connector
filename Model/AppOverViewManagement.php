<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppOverViewRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\Config as AppOverViewConfig;
use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AppOverViewManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class AppOverViewManagement implements AppOverViewRepositoryInterface
{
    /**
     * @var AppOverViewConfig
     */
    private $overViewConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param AppOverViewConfig $overViewConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        AppOverViewConfig $overViewConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->overViewConfig = $overViewConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function getAppTenantId()
    {
        try {
            /** @var AppOverViewConfig */
            $tenantId = $this->overViewConfig->getTenantId();
            if (empty($tenantId)) {
                $tenantId = $this->getBaseUrl();
            }
            $domain =  $this->getDomainName($tenantId);
            $data = [
                AppOverViewConfig::AW_TENANT_ID => $domain
            ];
            $overViewData[] = $data;
            return $overViewData;
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

    /**
     * Returns base url to file according to store configuration
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
    }

    /**
     * Processing save app overview data
     *
     * @param array $data
     * @return $this
     */
    public function save(array $data)
    {
        $this->overViewConfig->setTenantId($data[AppOverViewConfig::AW_TENANT_ID]);
        return $this;
    }
}
