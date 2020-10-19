<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\FileSystem\RemaningDownload;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;

/**
 * Class RemainingDownloads
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class RemainingDownloads implements ModifierInterface
{
    /**
     * @var dataResolver
     */
    private $remainingDownload;

    /**
     * @param RemaningDownload $remainingDownload
     */
    public function __construct(
        RemaningDownload $remainingDownload
    ) {
        $this->remainingDownload = $remainingDownload;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if (isset($item['number_of_downloads_bought'])) {
            $item->setData(
                LibraryItemInterface::REMAINING_DOWNLOADS,
                $this->remainingDownload->getRemaningDownload($item)
            );
        }
        return $item;
    }
}
