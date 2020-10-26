<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;

/**
 * Class getRemainingDownloads
 *
 * @package Aheadworks\DigitalMedia\Model\Downloadable\Link\Purchased\Item
 */
class GetRemainingDownloads
{

    /**
     *  Return number of left downloads or unlimited
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
