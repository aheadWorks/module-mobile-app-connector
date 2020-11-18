<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppPreferencesDataManagementInterface;
use Aheadworks\MobileAppConnector\Model\Config\Source\Font;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Exception;
use Magento\Cms\Helper\Page;
use Magento\Framework\UrlInterface;

class AppPreferencesDataManagement implements AppPreferencesDataManagementInterface
{

    /**
     * @var PreferencesConfig
     */
    private $preferencesConfig;

    /**
     * @var Font
     */
    protected $font;
    /**
     * Cms page
     *
     * @var Page
     */
    protected $cmsPage;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param PreferencesConfig $preferencesConfig
     * @param UrlInterface $urlBuilder
     * @param Page $cmsPage
     * @param Font $font
     */
    public function __construct(
        PreferencesConfig $preferencesConfig,
        UrlInterface $urlBuilder,
        Page $cmsPage,
        Font $font
    ) {
        $this->preferencesConfig = $preferencesConfig;
        $this->urlBuilder = $urlBuilder;
        $this->font = $font;
        $this->cmsPage = $cmsPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppPreferencesData()
    {
        $preferenceData = [];
        try {
            $folderName = PreferencesConfig::LOGO;
            $appLogoPath = $this->preferencesConfig->getLogo();
            $path = $folderName . '/' . $appLogoPath;

            $appLogoUrl = $this->urlBuilder
                ->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $path;

            $fontLabel = $this->font->getOptionByValue($this->preferencesConfig->getFontFamily());
            $policyPageUrl = $this->cmsPage->getPageUrl($this->preferencesConfig->getPolicyPageId());
            $contactPageUrl = $this->cmsPage->getPageUrl($this->preferencesConfig->getContactPageId());

            $data = [
            PreferencesConfig::APP_NAME => $this->preferencesConfig->getAppName(),
            PreferencesConfig::LOGO => $appLogoUrl ,
            PreferencesConfig::FONT_FAMILY => $fontLabel,
            PreferencesConfig::COLOR_PREFERENCE => $this->preferencesConfig->getColorPreference(),
            PreferencesConfig::POLICY_PAGE => $policyPageUrl,
            PreferencesConfig::CONTACT_PAGE => $contactPageUrl
        ];

            $preferenceData[] = $data;
        } catch (Exception $e) {
            throw new Exception("We can\'t get App data.");
        }
        return $preferenceData;
    }
}
