<?php
namespace Aheadworks\MobileAppConnector\Model\Source\Data;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class for Format
 */
class Type implements OptionSourceInterface
{
    /**#@+
     * Constants defined for the source model
     */
    public const OTHER_TYPE = 'other';
    public const PDF_TYPE = 'book';
    public const MP3_TYPE = 'audio';
    public const MP4_TYPE = 'video';
    /**#@-*/

    /**
     * To option array
     *
     * @return array
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
