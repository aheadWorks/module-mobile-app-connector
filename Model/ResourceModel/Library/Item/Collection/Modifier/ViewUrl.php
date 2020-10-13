<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Magento\Framework\UrlInterface;
/**
 * Class ViewUrl
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class ViewUrl implements ModifierInterface
{
    /**
     * @var UrlBuilder
     */
    private $urlBuilder;

    /**
     * @param UrlBuilder $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        $linkHash = $item->getData(LibraryItemInterface::LINK_HASH);
        $item->setData(
            LibraryItemInterface::VIEW_URL,
            $this->getItemDownloadUrl($linkHash)
        );
        return $item;
    }

    /**
     * Retrieve url to download item
     *
     * @param string $linkHash
     * @param array $additionalParams
     * @return string
     */
    protected function getItemDownloadUrl($linkHash, $additionalParams = [])
    {
        $params = $additionalParams;
        $params['id'] = $linkHash;
        $params['_secure'] = true;
        return $this->urlBuilder->getUrl(
            'downloadable/download/link',
            $params
        );
    }
}
