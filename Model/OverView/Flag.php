<?php
namespace Aheadworks\MobileAppConnector\Model\OverView;

/**
 * Class Flag
 * @package Aheadworks\MobileAppConnector\Model\OverView
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
    public function setOverViewFlagCode($code)
    {
        $this->_flagCode = $code;
        return $this;
    }
}
