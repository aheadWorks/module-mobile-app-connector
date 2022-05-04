<?php
namespace Aheadworks\MobileAppConnector\Model\Source\Data;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Format
 *
 * @package Aheadworks\MobileAppConnector\Model\Source\Email
 */
class Type implements OptionSourceInterface
{
    /**#@+
     * Constants defined for the source model
     */
    const OTHER_TYPE = 'other';
    const PDF_TYPE = 'book';
    const MP3_TYPE = 'audio';
    const MP4_TYPE = 'video';
    /**#@-*/

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::OTHER_TYPE, 'label' => __('Other')],
            ['value' => self::PDF_TYPE, 'label' => __('Book')],
            ['value' => self::MP3_TYPE, 'label' => __('Audio')],
            ['value' => self::MP4_TYPE, 'label' => __('Video')]
        ];
    }
}
