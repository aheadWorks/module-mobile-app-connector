<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppPreferencesDataManagementInterface;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Aheadworks\MobileAppConnector\Model\Preferences\Manager\UrlBuilder;

class AppPreferencesDataManagement implements AppPreferencesDataManagementInterface
{

    /**
     * @var PreferencesConfig
     */
    private $PreferencesConfig;
    /**
     * @var UrlBuilder
     */
    private $urlBuilder;

    /**
    * @param PreferencesConfig $PreferencesConfig
    * @param UrlBuilder $urlBuilder
    */
    public function __construct(
        PreferencesConfig $PreferencesConfig,
        UrlBuilder $urlBuilder
    ) {
        $this->PreferencesConfig = $PreferencesConfig;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppPreferencesData()
    {
        $preferenceData = [];
        try {
            $urlToMediaFolder = $this->urlBuilder->getUrlToMediaFolder();
            $logoPath = PreferencesConfig::LOGO_PATH . '/' . $this->PreferencesConfig->getLogo();
            $data = [
            PreferencesConfig::APP_NAME => $this->PreferencesConfig->getAppName(),
            PreferencesConfig::LOGO => $urlToMediaFolder . $logoPath ,
            PreferencesConfig::FONT_FAMILY => $this->PreferencesConfig->getFontFamily(),
            PreferencesConfig::COLOR_PREFERENCE => $this->PreferencesConfig->getColorPreference(),
            PreferencesConfig::POLICY_PAGE => $this->PreferencesConfig->getPolicyPage(),
            PreferencesConfig::CONTACT_PAGE => $this->PreferencesConfig->getContactPage()
        ];
            $preferenceData[] = $data;
        } catch (\Exception $e) {
            //DO Nothing
        }
        return $preferenceData;
    }
}
