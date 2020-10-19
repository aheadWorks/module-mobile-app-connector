<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;

/**
 * Class Processor
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Processor
{
    /**
     * Postprocessing for link item downloading
     *
     * @param PurchasedLinkItemModel $purchasedLinkItem
     * @return PurchasedLinkItemModel
     * @throws \Exception
     */
    public function postprocessDownloading($purchasedLinkItem)
    {
        $purchasedLinkItem->setNumberOfDownloadsUsed(
            $purchasedLinkItem->getNumberOfDownloadsUsed() + 1
        );

        if ($purchasedLinkItem->getNumberOfDownloadsBought() != 0
            && ($purchasedLinkItem->getNumberOfDownloadsBought() == $purchasedLinkItem->getNumberOfDownloadsUsed())
        ) {
            $purchasedLinkItem->setStatus(PurchasedLinkItemModel::LINK_STATUS_EXPIRED);
        }

        $purchasedLinkItem->save();

        return $purchasedLinkItem;
    }
}
