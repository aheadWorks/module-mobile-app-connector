<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Checker as ItemChecker;


/**
 * Class IsDownloadable
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class IsDownloadable implements ModifierInterface
{
    /**
     * @var itemChecker
     */
    private $itemChecker;

    /**
     * @param itemChecker $itemChecker
     */
    public function __construct(
        ItemChecker $itemChecker
    ) {
        $this->itemChecker = $itemChecker;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        $item->setData(
            LibraryItemInterface::IS_DOWNLOADABLE,
                $this->itemChecker->getIsDownloadable($item) 
        ); 

        return $item;
    }
}
