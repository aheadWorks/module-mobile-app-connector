<?php
namespace Aheadworks\MobileAppConnector\Model\FileSystem;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Source\Data\Type;

/**
 * Class Filetype
 *
 * @package Aheadworks\MobileAppConnector\Model\FileSystem
 */
class Filetype
{
    /**
     * Retrieve item file type
     *
     * @param LibraryItemInterface $item
     * @return string
     */
    public function getItemType($item)
    {
        $type = Type::OTHER_TYPE;
        $linkFile =  $item['link_file'];
        $ext = pathinfo($linkFile, PATHINFO_EXTENSION);
        if (strtolower('pdf') === strtolower($ext)) {
            $type = Type::PDF_TYPE;
        }
        if (strtolower('mp3') === strtolower($ext)) {
            $type = Type::MP3_TYPE;
        }
        if (strtolower('mp4') === strtolower($ext)) {
            $type = Type::MP4_TYPE;
        }
        return $type;
    }
}
