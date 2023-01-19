<?php
namespace Aheadworks\MobileAppConnector\Model\FileSystem;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Source\Data\Type;

/**
 * Class for Filetype
 */
class Filetype
{
    /**#@+
     * Constants defined for file type.
     */
    public const PDF = 'pdf';
    public const MP3 = 'mp3';
    public const MP4 = 'mp4';
    /**#@-*/

    /**
     * Retrieve item file type
     *
     * @param LibraryItemInterface $item
     * @return string
     */
    public function getItemType($item)
    {
        $type = Type::OTHER_TYPE;

        if (isset($item['link_file']) && ($item['link_type'] =='file')) {
            $linkFile =  $item['link_file'];
            // @codingStandardsIgnoreStart
            $ext = pathinfo($linkFile, PATHINFO_EXTENSION);
            if (self::PDF === strtolower($ext)) {
                $type = Type::PDF_TYPE;
            }
            if (self::MP3 === strtolower($ext)) {
                $type = Type::MP3_TYPE;
            }
            if (self::MP4 === strtolower($ext)) {
                $type = Type::MP4_TYPE;
            }
            // @codingStandardsIgnoreEnd
        }
        return $type;
    }
}
