<?php
namespace Aheadworks\MobileAppConnector\Model\Url;

use Magento\Framework\UrlInterface;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;

/**
 * Class Builder
 *
 * @package Aheadworks\MobileAppConnector\Model\Url
 */
class Builder
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var PreferencesConfig
     */
    private $preferencesConfig;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder,
        PreferencesConfig $preferencesConfig
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->preferencesConfig = $preferencesConfig;
    }

    /**
     * Retrieve App logo Url
     *
     * @param string $appLogoImage
     * @return string
     */
    public function getAppLogoUrl($appLogoImage)
    {
        $folderName = PreferencesConfig::APP_LOGO;
        $path = $folderName . '/' . $appLogoImage;
        $appLogoUrl = $this->urlBuilder
            ->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $path;
        return $appLogoUrl;
    }
}
