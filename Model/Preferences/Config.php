<?php
namespace Aheadworks\MobileAppConnector\Model\Preferences;

use Magento\Framework\FlagManager;

/**
 * Class for Config
 */
class Config
{
    /**#@+
     * App Preferences constants
     */
    public const APP_NAME = 'app_name';
    public const APP_LOGO = 'applogo';
    public const FONT_FAMILY = 'font_family';
    public const COLOR_PREFERENCE = 'color_preference';
    public const POLICY_PAGE = 'policy_page';
    public const CONTACT_PAGE = 'contact_page';
    /**#@-*/

    /**
     * @var FlagManager
     */
    private $flagManager;

    /**
     * @param FlagManager $flagManager
     */
    public function __construct(
        FlagManager $flagManager
    ) {
        $this->flagManager = $flagManager;
    }
    /**
     * Get App name
     *
     * @return string
     */
    public function getAppName()
    {
        return $this->flagManager->getFlagData(self::APP_NAME);
    }

    /**
     * Save App name
     *
     * @param string $appName
     * @return bool
     */
    public function saveAppName($appName)
    {
        return $this->flagManager
           ->saveFlag(self::APP_NAME, $appName);
    }
    /**
     * Get App logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->flagManager->getFlagData(self::APP_LOGO);
    }

    /**
     * Save App logo
     *
     * @param string $logo
     * @return bool
     */
    public function saveLogo($logo)
    {
        return $this->flagManager
           ->saveFlag(self::APP_LOGO, $logo);
    }
    /**
     * Get App font family
     *
     * @return string
     */
    public function getFontFamily()
    {
        return $this->flagManager->getFlagData(self::FONT_FAMILY);
    }

    /**
     * Save App font family
     *
     * @param string $fontFamily
     * @return bool
     */
    public function saveFontFamily($fontFamily)
    {
        return $this->flagManager
           ->saveFlag(self::FONT_FAMILY, $fontFamily);
    }
    /**
     * Get App color preference
     *
     * @return string
     */
    public function getColorPreference()
    {
        return $this->flagManager->getFlagData(self::COLOR_PREFERENCE);
    }

    /**
     * Save App color preference
     *
     * @param string $colorPreference
     * @return bool
     */
    public function saveColorPreference($colorPreference)
    {
        return $this->flagManager
           ->saveFlag(self::COLOR_PREFERENCE, $colorPreference);
    }
    /**
     * Get App policy page
     *
     * @return string
     */
    public function getPolicyPageId()
    {
        return $this->flagManager->getFlagData(self::POLICY_PAGE);
    }

    /**
     * Save App policy page
     *
     * @param string $policyPage
     * @return bool
     */
    public function savePolicyPageId($policyPage)
    {
        return $this->flagManager
           ->saveFlag(self::POLICY_PAGE, $policyPage);
    }
    /**
     * Get App contact page
     *
     * @return string
     */
    public function getContactPageId()
    {
        return $this->flagManager->getFlagData(self::CONTACT_PAGE);
    }

    /**
     * Save App contact page
     *
     * @param string $contactPage
     * @return bool
     */
    public function saveContactPageId($contactPage)
    {
        return $this->flagManager
           ->saveFlag(self::CONTACT_PAGE, $contactPage);
    }
}
