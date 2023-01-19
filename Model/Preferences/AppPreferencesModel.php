<?php

namespace Aheadworks\MobileAppConnector\Model\Preferences;

use Aheadworks\MobileAppConnector\Model\Upload\ImageUploader;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class for AppPreferencesModel
 */
class AppPreferencesModel
{
    /**
     * app logo database column name
     */
    public const APP_IMAGE_NAME = 'image';
    /**
     * @var Config
     */
    private $config;
    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * @param Config $config
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Config $config,
        ImageUploader $imageUploader
    ) {
        $this->config = $config;
        $this->imageUploader = $imageUploader;
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
        if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
            $this->imageUploader->moveFileFromTmp($data['image']);
        } elseif (isset($data['image'][0]['name']) && !isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            unset($data['image']);
        }

        if (!empty($data[Config::APP_NAME])) {
            $this->config->saveAppName($data[Config::APP_NAME]);
        }
        if (!empty($data[self::APP_IMAGE_NAME])) {
            $this->config->saveLogo($data[self::APP_IMAGE_NAME]);
        }

        if (!empty($data[Config::FONT_FAMILY])) {
            $this->config->saveFontFamily($data[Config::FONT_FAMILY]);
        }
        if (!empty($data[Config::COLOR_PREFERENCE])) {
            $this->config->saveColorPreference($data[Config::COLOR_PREFERENCE]);
        }
        if (!empty($data[Config::POLICY_PAGE])) {
            $this->config->savePolicyPageId($data[Config::POLICY_PAGE]);
        }
        if (!empty($data[Config::CONTACT_PAGE])) {
            $this->config->saveContactPageId($data[Config::CONTACT_PAGE]);
        }
        return $this;
    }
}
