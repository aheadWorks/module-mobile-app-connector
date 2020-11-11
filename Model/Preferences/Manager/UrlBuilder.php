<?php
namespace Aheadworks\MobileAppConnector\Model\Preferences\Manager;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class UrlBuilder
 *
 * @package Aheadworks\MobileAppConnector\Model\Preferences\Manager
 */
class UrlBuilder
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * Get url to media folder
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getUrlToMediaFolder()
    {
        $store = $this->storeManager->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * Get base Url
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getBaseUrl()
    {
        $store = $this->storeManager->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB);
    }
}
