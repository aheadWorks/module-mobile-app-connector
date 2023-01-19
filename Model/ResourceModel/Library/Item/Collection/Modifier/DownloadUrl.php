<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Url\Builder as UrlBuilder;

/**
 * Class for DownloadUrl
 */
class DownloadUrl implements ModifierInterface
{
    /**
     * @var UrlBuilder
     */
    private $urlBuilder;

    /**
     * @param UrlBuilder $urlBuilder
     */
    public function __construct(
        UrlBuilder $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Modify data
     *
     * @param string $item
     * @return string
     */
    public function modifyData($item)
    {
        $linkHash = $item->getData(LibraryItemInterface::LINK_HASH);
        $item->setData(
            LibraryItemInterface::DOWNLOAD_URL,
            $this->urlBuilder->getLibraryItemDownloadUrl($linkHash)
        );
        return $item;
    }
}
