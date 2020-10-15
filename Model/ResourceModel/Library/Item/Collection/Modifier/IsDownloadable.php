<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Aditional\Resolver as AditionalResolver;
/**
 * Class IsDownloadable
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class IsDownloadable implements ModifierInterface
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
        $item->setData(
            LibraryItemInterface::IS_DOWNLOADABLE,
                $this->aditionalResolver->getIsDownloadble($item) 
        ); 

        return $item;
    }
}
