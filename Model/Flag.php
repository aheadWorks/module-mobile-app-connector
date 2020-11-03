<?php
namespace Aheadworks\MobileAppConnector\Model;

/**
 * Class Flag
 * @package Aheadworks\MobileAppConnector\Model
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
    public function setMACFlagCode($code)
    {
        $this->_flagCode = $code;
        return $this;
    }
}
