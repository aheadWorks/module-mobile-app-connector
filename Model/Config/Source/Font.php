<?php
namespace Aheadworks\MobileAppConnector\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Font
 * @package Aheadworks\MobileAppConnector\Model\Config\Source
 */
class Font implements OptionSourceInterface
{
    /**#@+
     * Font values
     */
    const ARIAL           = 1;
    const HELVETICA_NEUE  = 2;
    const VERDANA         = 3;
    const SAN_FRANCISCO   = 4;
    /**#@-*/

    /**
     * {@inheritdoc}
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
