<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Block\Adminhtml\System\Config\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Toggle - field's type
 */
class Toggle extends Field
{
    public const ENABLE_VALUE = 1;
    public const DISABLE_VALUE = 0;

    /**
     * @var string
     */
    protected $_template = 'system/config/field/toggle.phtml';

    /**
     * Retrieve element HTML markup
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $this->setNamePrefix($element->getName())
            ->setHtmlId($element->getHtmlId())
            ->setIsElementDisabled($element->getData('disabled'))
            ->setElementValue($element->getData('value'));

        return $this->_toHtml();
    }

    /**
     * Field is checked or not
     *
     * @return bool
     */
    public function getIsChecked(): bool
    {
        return $this->getEnableValue() === (int)$this->getElementValue();
    }

    /**
     * Field disabled or not
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return (bool)$this->getIsElementDisabled();
    }

    /**
     * Get enable value for field
     *
     * @return int
     */
    public function getEnableValue(): int
    {
        return self::ENABLE_VALUE;
    }

    /**
     * Get disable value for field
     *
     * @return int
     */
    public function getDisableValue(): int
    {
        return self::DISABLE_VALUE;
    }
}
