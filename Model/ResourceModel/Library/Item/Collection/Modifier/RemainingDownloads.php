<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Downloadable\Resolver as Resolver;
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
    private $dataResolver;

    /**
     * @param dataResolver $dataResolver
     */
    public function __construct(
        Resolver $dataResolver
    ) {
        $this->dataResolver = $dataResolver;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if(isset($item['number_of_downloads_bought'])){
            $item->setData(
                LibraryItemInterface::REMAINING_DOWNLOADS,
                $this->dataResolver->getRemaningDownload($item)
            ); 
        }
        return $item;
    }
}
