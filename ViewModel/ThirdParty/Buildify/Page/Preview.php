<?php
namespace Aheadworks\MobileAppConnector\ViewModel\ThirdParty\Buildify\Page;

use Magento\Framework\App\RequestInterface;

/**
 * Class for Preview
 */
class Preview
{
    /**
     * Additional class for buildify preview
     */
    public const MOBILE_APP_CONNECTOR_BUILDIFY_CLASS = 'buildify-preview-mobile-app-connector';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Retrieve additional class for buildify preview
     *
     * @return string
     */
    public function getClass()
    {
        $class = '';

        if ($this->request->getParam('mobile_app_connector')) {
            $class = self::MOBILE_APP_CONNECTOR_BUILDIFY_CLASS;
        }

        return $class;
    }
}
