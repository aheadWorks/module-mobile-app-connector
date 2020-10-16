<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Info\Resolver as InfoResolver;
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
        InfoResolver $aditionalResolver
    ) {
        $this->aditionalResolver = $aditionalResolver;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if(isset($item['number_of_downloads_bought'])){
            $item->setData(
                LibraryItemInterface::REMAINING_DOWNLOADS,
                $this->aditionalResolver->getRemaningDownload($item)
            ); 
        }
        return $item;
    }
}
