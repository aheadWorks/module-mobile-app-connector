<?php
namespace Aheadworks\MobileAppConnector\Model\Url;

use Magento\Framework\UrlInterface;

/**
 * Class Builder
 *
 * @package Aheadworks\MobileAppConnector\Model\Url
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
     * Retrieve url to download item
     *
     * @param string $linkHash
     * @param array $additionalParams
     * @return string
     */
    public function getItemDownloadUrl($linkHash, $additionalParams = [])
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
