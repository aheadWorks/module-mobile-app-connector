<?php
namespace Aheadworks\MobileAppConnector\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class for Font
 */
class Font implements OptionSourceInterface
{
    /**#@+
     * Font values
     */
    public const ARIAL = 1;
    public const HELVETICA_NEUE = 2;
    public const VERDANA = 3;
    public const SAN_FRANCISCO = 4;
    /**#@-*/

    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 0,
                'label' => __('Not set')
            ],
            [
                'value' => self::ARIAL,
                'label' => __('Arial')
            ],
            [
                'value' => self::HELVETICA_NEUE,
                'label' => __('Helvetica Neue')
            ],
            [
                'value' => self::VERDANA,
                'label' => __('Verdana')
            ],
            [
                'value' => self::SAN_FRANCISCO,
                'label' => __('San Francisco')
            ],
        ];
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        $optionsArray = $this->toOptionArray();
        $options = [];
        foreach ($optionsArray as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    /**
     * Get option by value
     *
     * @param int $value
     * @return string|null
     */
    public function getOptionByValue($value)
    {
        $options = $this->getOptions();
        if (array_key_exists($value, $options)) {
            return $options[$value];
        }
        return null;
    }
}
