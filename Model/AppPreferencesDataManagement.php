<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\AppPreferencesDataManagementInterface;
use Aheadworks\MobileAppConnector\Model\Config\Source\Font;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Exception;
use Magento\Cms\Helper\Page;
use Aheadworks\MobileAppConnector\Model\Url\Builder;

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
    protected $cmsPageHelper;
    /**
     * @var Builder
     */
    protected $urlBuilder;

    /**
     * @param PreferencesConfig $preferencesConfig
     * @param Builder $urlBuilder
     * @param Page $cmsPageHelper
     * @param Font $font
     */
    public function __construct(
        PreferencesConfig $preferencesConfig,
        Builder $urlBuilder,
        Page $cmsPageHelper,
        Font $font
    ) {
        $this->preferencesConfig = $preferencesConfig;
        $this->urlBuilder = $urlBuilder;
        $this->font = $font;
        $this->cmsPageHelper = $cmsPageHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppPreferencesData()
    {
        $preferenceData = [];
        try {
            $appLogoUrl = $this->urlBuilder->getAppLogoUrl($this->preferencesConfig->getLogo());
            $fontLabel = $this->font->getOptionByValue($this->preferencesConfig->getFontFamily());
            $policyPageUrl = $this->cmsPageHelper->getPageUrl($this->preferencesConfig->getPolicyPageId());
            $contactPageUrl = $this->cmsPageHelper->getPageUrl($this->preferencesConfig->getContactPageId());

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
