<?php
namespace Aheadworks\MobileAppConnector\Plugin\AwBuildify\Model\Service;

use Aheadworks\Buildify\Model\Service\UrlService;
use Aheadworks\Buildify\Model\Entity\Config;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;

/**
 * Class for UrlService
 */
class UrlServicePlugin
{
    /**
     * Add additional parameter mobile_app_connector to the /builder request
     */
    public const BUILDER_ROUTE_PATH = 'builder';

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Before get url
     *
     * @param UrlService $subject
     * @param string $routePath
     * @param array $routeParams
     * @param bool $addAdditional
     * @return array
     */
    public function beforeGetUrl(UrlService $subject, $routePath, $routeParams = [], $addAdditional = true)
    {
        if ($routePath == self::BUILDER_ROUTE_PATH
            && $this->config->getExtensionAttributesKey() == HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT
        ) {
            $routeParams['mobile_app_connector'] = true;
        }

        return [$routePath, $routeParams, $addAdditional];
    }
}
