<?php
namespace Aheadworks\MobileAppConnector\Model\Publishapp;

use Magento\Framework\FlagManager;

/**
 * Class for Config
 */
class Config
{
    /**#@+
     * App Publishapp constants
     */
    public const APP_TITLE = 'app_title';
    public const SHORT_DESCRIPTION_OF_MOBILE_APP = 'short_description_of_mobile_app';
    public const LONG_DESCRIPTION_OF_MOBILE_APP = 'long_description_of_mobile_app';
    public const KEYWORDS = 'keywords';
    public const SUPPORT_MAIL = 'support_mail';
    public const PRIVACY_POLICY_LINK = 'privacy_policy_link';
    public const SUPPORT_TELEPHONE_NUMBER = 'support_telephone_number';
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
     * Get App title
     *
     * @return string
     */
    public function getAppTitle()
    {
        return $this->flagManager->getFlagData(self::APP_TITLE);
    }

    /**
     * Save App title
     *
     * @param string $appTitle
     * @return bool
     */
    public function saveAppTitle($appTitle)
    {
        return $this->flagManager
           ->saveFlag(self::APP_TITLE, $appTitle);
    }

    /**
     * Get Short description of mobile app
     *
     * @return string
     */
    public function getShortDescriptionOfMobileApp()
    {
        return $this->flagManager->getFlagData(self::SHORT_DESCRIPTION_OF_MOBILE_APP);
    }

    /**
     * Save Short description of mobile app
     *
     * @param string $shortDescriptionOfMobileapp
     * @return bool
     */
    public function saveShortDescriptionOfMobileApp($shortDescriptionOfMobileapp)
    {
        return $this->flagManager
           ->saveFlag(self::SHORT_DESCRIPTION_OF_MOBILE_APP, $shortDescriptionOfMobileapp);
    }

    /**
     * Get Long description of mobile app
     *
     * @return string
     */
    public function getLongDescriptionOfMobileApp()
    {
        return $this->flagManager->getFlagData(self::LONG_DESCRIPTION_OF_MOBILE_APP);
    }

    /**
     * Save Long description of mobile app
     *
     * @param string $longDescriptionOfMobileApp
     * @return bool
     */
    public function saveLongDescriptionOfMobileApp($longDescriptionOfMobileApp)
    {
        return $this->flagManager
           ->saveFlag(self::LONG_DESCRIPTION_OF_MOBILE_APP, $longDescriptionOfMobileApp);
    }

    /**
     * Get App keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->flagManager->getFlagData(self::KEYWORDS);
    }

    /**
     * Save App keywords
     *
     * @param string $keywords
     * @return bool
     */
    public function saveKeywords($keywords)
    {
        return $this->flagManager
           ->saveFlag(self::KEYWORDS, $keywords);
    }

    /**
     * Get App support mail
     *
     * @return string
     */
    public function getSupportMail()
    {
        return $this->flagManager->getFlagData(self::SUPPORT_MAIL);
    }

    /**
     * Save App support mail
     *
     * @param string $supportMail
     * @return bool
     */
    public function saveSupportMail($supportMail)
    {
        return $this->flagManager
           ->saveFlag(self::SUPPORT_MAIL, $supportMail);
    }

    /**
     * Get App policy policy link
     *
     * @return string
     */
    public function getPolicyPolicyLink()
    {
        return $this->flagManager->getFlagData(self::PRIVACY_POLICY_LINK);
    }

    /**
     * Save App policy policy link
     *
     * @param string $policyPolicylink
     * @return bool
     */
    public function savePolicyPolicyLink($policyPolicylink)
    {
        return $this->flagManager
           ->saveFlag(self::PRIVACY_POLICY_LINK, $policyPolicylink);
    }

    /**
     * Get App support telephone number
     *
     * @return string
     */
    public function getSupportTelephoneNumber()
    {
        return $this->flagManager->getFlagData(self::SUPPORT_TELEPHONE_NUMBER);
    }

    /**
     * Save App support telephone number
     *
     * @param string $supportTelephoneNumber
     * @return bool
     */
    public function saveSupportTelephoneNumber($supportTelephoneNumber)
    {
        return $this->flagManager
           ->saveFlag(self::SUPPORT_TELEPHONE_NUMBER, $supportTelephoneNumber);
    }
}
