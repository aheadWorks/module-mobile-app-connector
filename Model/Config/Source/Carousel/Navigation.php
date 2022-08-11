<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Config\Source\Carousel;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Navigation config source
 */
class Navigation implements OptionSourceInterface
{
    public const ARROWS_DOTS_SELECT_VAL = 0;
    public const ARROWS_SELECT_VAL = 1;
    public const DOTS_SELECT_VAL = 2;
    public const NONE_SELECT_VAL = 3;

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::ARROWS_DOTS_SELECT_VAL, 'label' => __('Arrows and Dots')],
            ['value' => self::ARROWS_SELECT_VAL, 'label' => __('Arrows')],
            ['value' => self::DOTS_SELECT_VAL, 'label' => __('Dots')],
            ['value' => self::NONE_SELECT_VAL, 'label' => __('None')]
        ];
    }
}
