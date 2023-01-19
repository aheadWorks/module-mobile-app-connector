<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Magento\Framework\Exception\LocalizedException;
use Magento\Downloadable\Helper\Data as DownloadableDataHelper;
use Magento\Framework\Exception\AuthorizationException;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Provider as PurchasedLinkProvider;

/**
 * Class for validator
 */
class Validator
{
    /**
     * @var DownloadableDataHelper
     */
    private $downloadableDataHelper;

    /**
     * @var PurchasedLinkProvider
     */
    private $purchasedLinkProvider;

    /**
     * @param DownloadableDataHelper $downloadableDataHelper
     * @param PurchasedLinkProvider $purchasedLinkProvider
     */
    public function __construct(
        DownloadableDataHelper $downloadableDataHelper,
        PurchasedLinkProvider $purchasedLinkProvider
    ) {
        $this->downloadableDataHelper = $downloadableDataHelper;
        $this->purchasedLinkProvider = $purchasedLinkProvider;
    }

    /**
     * Check if link is available to download
     *
     * @param PurchasedLinkItemModel $purchasedLinkItem
     * @param int $customerId
     * @return bool
     * @throws LocalizedException
     * @throws AuthorizationException
     */
    public function validateForDownloading($purchasedLinkItem, $customerId)
    {
        if (!$purchasedLinkItem->getId()) {
            throw new LocalizedException(__("We can't find the link you requested."));
        }

        if (!$this->downloadableDataHelper->getIsShareable($purchasedLinkItem)) {
            if (!$customerId) {
                throw new AuthorizationException(__("Please sign in to download your product."));
            }

            $purchasedLink = $this->purchasedLinkProvider->getById($purchasedLinkItem->getPurchasedId());
            if ($purchasedLink->getCustomerId() != $customerId) {
                throw new LocalizedException(__("We can't find the link you requested."));
            }
        }

        $purchasedLinkItemStatus = $purchasedLinkItem->getStatus();
        $qtyOfDownloadsLeft = $purchasedLinkItem->getNumberOfDownloadsBought()
            - $purchasedLinkItem->getNumberOfDownloadsUsed()
        ;

        if ($purchasedLinkItemStatus == PurchasedLinkItemModel::LINK_STATUS_EXPIRED) {
            throw new LocalizedException(__("The link has expired."));
        }
        if ($purchasedLinkItemStatus == PurchasedLinkItemModel::LINK_STATUS_PENDING
            || $purchasedLinkItemStatus == PurchasedLinkItemModel::LINK_STATUS_PAYMENT_REVIEW
        ) {
            throw new LocalizedException(__("The link is not available."));
        }

        if ($purchasedLinkItemStatus == PurchasedLinkItemModel::LINK_STATUS_AVAILABLE
            && ($qtyOfDownloadsLeft || $purchasedLinkItem->getNumberOfDownloadsBought() == 0)
        ) {
            return true;
        }

        throw new LocalizedException(__("Something went wrong while getting the requested content."));
    }
}
