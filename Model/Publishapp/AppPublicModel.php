<?php

namespace Aheadworks\MobileAppConnector\Model\Publishapp;

use Aheadworks\MobileAppConnector\Model\Upload\ImageUploader;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class for AppPublicModel
 */
class AppPublicModel
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Processing save preference data
     *
     * @param array $data
     * @return $this
     * @throws LocalizedException
     */
    public function save($data)
    {
        if (!empty($data[Config::APP_TITLE])) {
            $this->config->saveAppTitle($data[Config::APP_TITLE]);
        }
        if (!empty($data[Config::SHORT_DESCRIPTION_OF_MOBILE_APP])) {
            $this->config->saveShortDescriptionOfMobileApp($data[Config::SHORT_DESCRIPTION_OF_MOBILE_APP]);
        }
        if (!empty($data[Config::LONG_DESCRIPTION_OF_MOBILE_APP])) {
            $this->config->saveLongDescriptionOfMobileApp($data[Config::LONG_DESCRIPTION_OF_MOBILE_APP]);
        }
        if (!empty($data[Config::KEYWORDS])) {
            $this->config->saveKeywords($data[Config::KEYWORDS]);
        }
        if (!empty($data[Config::SUPPORT_MAIL])) {
            $this->config->saveSupportMail($data[Config::SUPPORT_MAIL]);
        }
        if (!empty($data[Config::PRIVACY_POLICY_LINK])) {
            $this->config->savePolicyPolicyLink($data[Config::PRIVACY_POLICY_LINK]);
        }
        if (!empty($data[Config::SUPPORT_TELEPHONE_NUMBER])) {
            $this->config->saveSupportTelephoneNumber($data[Config::SUPPORT_TELEPHONE_NUMBER]);
        }
        return $this;
    }
}
