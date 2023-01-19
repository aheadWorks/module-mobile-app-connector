<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Checker as PurchasedLinkItemChecker;

/**
 * Class for IsDownAheadworksloadable
 */
class IsDownloadable implements ModifierInterface
{
    /**
     * @var purchasedLinkItemChecker
     */
    private $purchasedLinkItemChecker;

    /**
     * @param PurchasedLinkItemChecker $purchasedLinkItemChecker
     */
    public function __construct(
        PurchasedLinkItemChecker $purchasedLinkItemChecker
    ) {
        $this->purchasedLinkItemChecker = $purchasedLinkItemChecker;
    }

    /**
     * Modify data
     *
     * @param string $item
     * @return string
     */
    public function modifyData($item)
    {
        $item->setData(
            LibraryItemInterface::IS_DOWNLOADABLE,
            $this->purchasedLinkItemChecker->isLibraryItem($item)
        );
        return $item;
    }
}
