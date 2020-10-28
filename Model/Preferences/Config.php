<?php
namespace Aheadworks\MobileAppConnector\Model\Preferences;

use Aheadworks\MobileAppConnector\Model\Preferences\Flag;
use Aheadworks\MobileAppConnector\Model\Preferences\FlagFactory;

/**
 * Class Config
 * @package Aheadworks\MobileAppConnector\Model\Preference
 */
class Config
{
    /**
     * Configuration path to tenant id
     */
    const AW_TENANT_ID = 'aw_tenant_id';
    const APP_NAME = 'app_name';
    const LOGO = 'logo';
    const FONT_FAMILY = 'font_family';
    const COLOR_PREFERENCE = 'color_preference';
    const POLICY_PAGE = 'policy_page';
    const CONTACT_PAGE = 'contact_page';

    /**
     * @var Flag
     */
    private $flag;

    /**
     * @param FlagFactory $flagFactory
     */
    public function __construct(
        FlagFactory $flagFactory
    ) {
        $this->flag = $flagFactory->create();
    }

    /**
     * Get flag data
     *
     * @param string $param
     * @return array
     */
    private function getFlagData($param)
    {
        $this->flag
            ->unsetData()
            ->setPreferencesFlagCode($param)
            ->loadSelf();

        return $this->flag->getFlagData();
    }

    /**
     * Set flag data
     *
     * @param string $param
     * @param mixed $value
     * @return $this
     */
    private function setFlagData($param, $value)
    {
        $this->flag
            ->unsetData()
            ->setPreferencesFlagCode($param)
            ->loadSelf()
            ->setFlagData($value)
            ->save();

        return $this;
    }

    /**
     * Get tenant id
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->getFlagData(self::AW_TENANT_ID);
    }

    /**
     * Set tenant id
     *
     * @param string $tenantId
     * @return $this
     */
    public function setTenantId($tenantId)
    {
        $this->setFlagData(self::AW_TENANT_ID, $tenantId);
        return $this;
    }

    public function getAppName()
    {
        return $this->getFlagData(self::APP_NAME);
    }
    public function setAppName($appName)
    {
        $this->setFlagData(self::APP_NAME, $appName);
        return $this;
    }
    public function getLogo()
    {
        return $this->getFlagData(self::LOGO);
    }
    public function setLogo($logo)
    {
        $this->setFlagData(self::LOGO, $logo);
        return $this;
    }
    public function getFontFamily()
    {
        return $this->getFlagData(self::FONT_FAMILY);
    }
    public function setFontFamily($fontFamily)
    {
        $this->setFlagData(self::FONT_FAMILY, $fontFamily);
        return $this;
    }
    public function getColorPreference()
    {
        return $this->getFlagData(self::COLOR_PREFERENCE);
    }
    public function setColorPreference($colorPreference)
    {
        $this->setFlagData(self::COLOR_PREFERENCE, $colorPreference);
        return $this;
    }
    public function getPolicyPage()
    {
        return $this->getFlagData(self::POLICY_PAGE);
    }
    public function setPolicyPage($policyPage)
    {
        $this->setFlagData(self::POLICY_PAGE, $policyPage);
        return $this;
    }
    public function getContactPage()
    {
        return $this->getFlagData(self::CONTACT_PAGE);
    }
    public function setContactPage($contactPage)
    {
        $this->setFlagData(self::CONTACT_PAGE, $contactPage);
        return $this;
    }
}