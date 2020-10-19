<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Checker;

/**
 * Class IsDownloadable
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class IsDownloadable implements ModifierInterface
{

    /**
     * @var Checker
     */
    private $checker;

    /*r
     * @param checker $checker
     */
    public function __construct(
        Checker $checker
    ) {
        $this->checker = $checker;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        $item->setData(
            LibraryItemInterface::IS_DOWNLOADABLE,
               $this->checker->isLibraryItem($item)
        ); 
        return $item;
    }
}
