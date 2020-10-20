<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\FileSystem\GetRemainingDownloads;
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
    private $remainingDownloads;

    /**
     * @param GetRemainingDownloads $remainingDownloads
     */
    public function __construct(
        GetRemainingDownloads $remainingDownloads
    ) {
        $this->remainingDownloads = $remainingDownloads;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if (isset($item['number_of_downloads_bought'])) {
            $item->setData(
                LibraryItemInterface::REMAINING_DOWNLOADS,
                $this->remainingDownloads->getRemaningDownload($item)
            );
        }
        return $item;
    }
}
