<?php
namespace Aheadworks\MobileAppConnector\Model\Url;

use Magento\Framework\UrlInterface;

/**
 * Class for Builder
 */
class Builder
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Retrieve url to download library item
     *
     * @param string $linkHash
     * @param array $additionalParams
     * @return string
     */
    public function getLibraryItemDownloadUrl($linkHash, $additionalParams = [])
    {
        $params = $additionalParams;
        $params['id'] = $linkHash;
        $params['_secure'] = true;
        return $this->urlBuilder->getUrl(
            'aw_mobile_app/download/link',
            $params
        );
    }
}
