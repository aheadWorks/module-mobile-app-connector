<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppPreferencesDataManagementInterface;
use Aheadworks\MobileAppConnector\Model\Config\Source\Font;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Aheadworks\MobileAppConnector\Model\Preferences\Manager\PageIdentifier;
use Aheadworks\MobileAppConnector\Model\Preferences\Manager\UrlBuilder;
use Exception;

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
     * @var Font
     */
    protected $font;

    /**
    * @param PreferencesConfig $PreferencesConfig
    * @param UrlBuilder $urlBuilder
    * @param PageIdentifier $pageIdentifier
    * @param Font $font
    */
    public function __construct(
        PreferencesConfig $PreferencesConfig,
        UrlBuilder $urlBuilder,
        PageIdentifier $pageIdentifier,
        Font $font
    ) {
        $this->PreferencesConfig = $PreferencesConfig;
        $this->urlBuilder = $urlBuilder;
        $this->pageIdentifier = $pageIdentifier;
        $this->font = $font;
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

            $logoPath = PreferencesConfig::LOGO . '/' . $this->PreferencesConfig->getLogo();

            $fontLabel = $this->font->getOptionByValue($this->PreferencesConfig->getFontFamily());

            $policyPageid = $this->PreferencesConfig->getPolicyPage();
            $policyPageIdentifier = $this->pageIdentifier->getPageIdentifierById($policyPageid);
            $policyPageUrl = $url . $policyPageIdentifier;

            $contactPageid = $this->PreferencesConfig->getContactPage();
            $contactPageIdentifier = $this->pageIdentifier->getPageIdentifierById($contactPageid);
            $contactPageUrl = $url . $contactPageIdentifier;

            $data = [
            PreferencesConfig::APP_NAME => $this->PreferencesConfig->getAppName(),
            PreferencesConfig::LOGO => $urlToMediaFolder . $logoPath ,
            PreferencesConfig::FONT_FAMILY => $fontLabel,
            PreferencesConfig::COLOR_PREFERENCE => $this->PreferencesConfig->getColorPreference(),
            PreferencesConfig::POLICY_PAGE => $policyPageUrl,
            PreferencesConfig::CONTACT_PAGE => $contactPageUrl
        ];
            $preferenceData[] = $data;
        } catch (\Exception $e) {
            throw new Exception("We can\'t get App data.");
        }
        return $preferenceData;
    }
}
