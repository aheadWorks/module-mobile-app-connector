<?php
namespace Aheadworks\MobileAppConnector\Model\FileSystem;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;

/**
 * Class getRemainingDownloads
 *
 * @package Aheadworks\MobileAppConnector\Model\FileSystem
 */
class GetRemainingDownloads
{

    /**
     * Retrieve item remainingdownloads
     *
     * @param LibraryItemInterface $item
     * @return string
     */
    public function getRemaningDownload($item)
    {
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
