<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Magento\Downloadable\Helper\File as DownloadableFileHelper;
use Magento\Downloadable\Helper\Download as DownloadableDownloadHelper;
use Magento\Downloadable\Model\Link as DownloadableLink;
use Magento\Downloadable\Model\LinkFactory as DownloadableLinkFactory;

/**
 * Class Resolver
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Resolver
{
    /**
     * @var DownloadableFileHelper
     */
    private $downloadableFileHelper;

    /**
     * @var DownloadableLinkFactory
     */
    private $downloadableLinkFactory;

    /**
     * @param DownloadableFileHelper $downloadableFileHelper
     * @param DownloadableLinkFactory $downloadableLinkFactory
     */
    public function __construct(
        DownloadableFileHelper $downloadableFileHelper,
        DownloadableLinkFactory $downloadableLinkFactory
    ){
        $this->downloadableFileHelper = $downloadableFileHelper;
        $this->downloadableLinkFactory = $downloadableLinkFactory;
    }

    /**
     * Retrieve full path for resource file
     *
     * @param PurchasedLinkItemModel $purchasedLinkItem
     * @return string
     */
    public function getResourceFilePath($purchasedLinkItem)
    {
        $resourceFilePath = '';

        if ($purchasedLinkItem->getLinkType() == DownloadableDownloadHelper::LINK_TYPE_URL) {
            $resourceFilePath = $purchasedLinkItem->getLinkUrl();
        } elseif ($purchasedLinkItem->getLinkType() == DownloadableDownloadHelper::LINK_TYPE_FILE) {
            /** @var DownloadableLink $downloadableLink */
            $downloadableLink = $this->downloadableLinkFactory->create();
            $resourceFilePath = $this->downloadableFileHelper->getFilePath(
                $downloadableLink->getBasePath(),
                $purchasedLinkItem->getLinkFile()
            );
        }

        return $resourceFilePath;
    }
}
