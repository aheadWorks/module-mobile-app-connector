<?php
namespace Aheadworks\MobileAppConnector\Model\Preferences;

/**
 * Class Flag
 * @package Aheadworks\MobileAppConnector\Model\Preference
 */
class Flag extends \Magento\Framework\Flag
{
    /**
     * Set flag code
     * @codeCoverageIgnore
     *
     * @param string $code
     * @return $this
     */
    public function setPreferencesFlagCode($code)
    {
        $this->_flagCode = $code;
        return $this;
    }
}