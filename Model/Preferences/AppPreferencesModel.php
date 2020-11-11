<?php

namespace Aheadworks\MobileAppConnector\Model\Preferences;

use Aheadworks\MobileAppConnector\Model\ImageUploader;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class AppPreferencesModel
 * @package Aheadworks\MobileAppConnector\Model\Preferences
 */
class AppPreferencesModel
{
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
     * @param $data
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

        if (!empty($data['app_name'])) {
            $this->config->setAppName($data[Config::APP_NAME]);
        }
        if (!empty($data['image'])) {
            $this->config->setLogo($data['image']);
        }

        if (!empty($data['font_family'])) {
            $this->config->setFontFamily($data['font_family']);
        }
        if (!empty($data['color_preference'])) {
            $this->config->setColorPreference($data['color_preference']);
        }
        if (!empty($data['policy_page'])) {
            $this->config->setPolicyPage($data['policy_page']);
        }
        if (!empty($data['contact_page'])) {
            $this->config->setContactPage($data['contact_page']);
        }
        return $this;
    }
}
