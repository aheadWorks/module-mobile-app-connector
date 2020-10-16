<?php
namespace Aheadworks\MobileAppConnector\Model\Info;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Source\Data\Type;

/**
 * Class Resolver
 *
 * @package Aheadworks\MobileAppConnector\Model\Info
 */
class Resolver
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

    /**
     * Retrieve item file remainingdownloads
     *
     * @param LibraryItemInterface $item
     * @return string
     */
    public function getRemaningDownload($item){

        $numberOfDownloadsUsed = $item['number_of_downloads_used'];
        $numberOfDownloadsBought = $item['number_of_downloads_bought'];

        if ($numberOfDownloadsBought) {
                $remainingDownloads = $numberOfDownloadsBought -$numberOfDownloadsUsed;
            } else {
                $remainingDownloads = __('Unlimited');
        }
        return $remainingDownloads;
    }
}
