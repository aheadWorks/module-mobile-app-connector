<?php
namespace Aheadworks\MobileAppConnector\Model\FileSystem;

/**
 * Class Resolver
 *
 * @package Aheadworks\MobileAppConnector\Model\FileSystem
 */
class Resolver
{

    /**
     * Retrieve item file remainingdownloads
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
