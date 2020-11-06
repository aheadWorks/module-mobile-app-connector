<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppPreferencesDataManagementInterface;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Aheadworks\MobileAppConnector\Model\Preferences\Manager\UrlBuilder;
use Aheadworks\MobileAppConnector\Model\Preferences\Manager\PageIdentifier;


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
     * @var PageIdentifier
     */
    protected $pageIdentifier;

    /**
    * @param PreferencesConfig $PreferencesConfig
    * @param UrlBuilder $urlBuilder
    * @param PageIdentifier $pageIdentifier
    */
    public function __construct(
        PreferencesConfig $PreferencesConfig,
        UrlBuilder $urlBuilder,
        PageIdentifier $pageIdentifier
    ) {
        $this->PreferencesConfig = $PreferencesConfig;
        $this->urlBuilder = $urlBuilder;
        $this->pageIdentifier = $pageIdentifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppPreferencesData()
    {
        $preferenceData = [];
        try {
            $urlToMediaFolder = $this->urlBuilder->getUrlToMediaFolder();
            $url = $this->urlBuilder->getBaseUrl();

            $logoPath = PreferencesConfig::LOGO_PATH . '/' . $this->PreferencesConfig->getLogo();

            $policyPageid = $this->PreferencesConfig->getPolicyPage();
            $policyPageIdentifier = $this->pageIdentifier->getPageIdentifierById($policyPageid);
            $policyPageUrl = $url.$policyPageIdentifier;

            $contactPageid = $this->PreferencesConfig->getContactPage();
            $contactPageIdentifier = $this->pageIdentifier->getPageIdentifierById($contactPageid);
            $contactPageUrl = $url.$contactPageIdentifier;

            $data = [
            PreferencesConfig::APP_NAME => $this->PreferencesConfig->getAppName(),
            PreferencesConfig::LOGO => $urlToMediaFolder . $logoPath ,
            PreferencesConfig::FONT_FAMILY => $this->PreferencesConfig->getFontFamily(),
            PreferencesConfig::COLOR_PREFERENCE => $this->PreferencesConfig->getColorPreference(),
            PreferencesConfig::POLICY_PAGE => $policyPageUrl,
            PreferencesConfig::CONTACT_PAGE => $contactPageUrl
        ];
            $preferenceData[] = $data;
        } catch (\Exception $e) {
            //DO Nothing
        }
        return $preferenceData;
    }
}
