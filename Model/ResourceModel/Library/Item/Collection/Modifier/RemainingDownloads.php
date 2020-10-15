<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Aditional\Resolver as AditionalResolver;
/**
 * Class RemainingDownloads
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class RemainingDownloads implements ModifierInterface
{
    /**
     * @var aditionalResolver
     */
    private $aditionalResolver;

    /**
     * @param aditionalResolver $aditionalResolver
     */
    public function __construct(
        AditionalResolver $aditionalResolver
    ) {
        $this->aditionalResolver = $aditionalResolver;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if(isset($item['number_of_downloads_bought'])){
           $numberOfDownloadsUsed = $item['number_of_downloads_used'];
           $numberOfDownloadsBought = $item['number_of_downloads_bought'];
            $item->setData(
                LibraryItemInterface::REMAINING_DOWNLOADS,
                $this->aditionalResolver->getRemaningDownload($numberOfDownloadsUsed, $numberOfDownloadsBought)
            ); 
        }
        return $item;
    }
}
