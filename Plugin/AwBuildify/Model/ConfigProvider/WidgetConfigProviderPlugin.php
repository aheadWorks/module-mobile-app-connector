<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Plugin\AwBuildify\Model\ConfigProvider;

use Aheadworks\Buildify\Model\ConfigProvider\WidgetConfigProvider as Subject;
use Aheadworks\MobileAppConnector\Block\Widget\Product\BestSellingProducts;
use Aheadworks\MobileAppConnector\Block\Widget\Product\MostViewedProducts;
use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\UrlInterface;
use Magento\Widget\Model\Widget\Config as WidgetConfig;

/**
 * Class Plugin for WidgetConfigProvider
 */
class WidgetConfigProviderPlugin
{
    const REQUEST_PAGE_IDENTIFIER = 'mobileappconnector/homepage';

    const SHOW_WIDGETS = [
        BestSellingProducts::class,
        MostViewedProducts::class
    ];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var WidgetConfig
     */
    private $widgetConfig;

    /**
     * WidgetConfigProviderPlugin constructor.
     *
     * @param Request $request
     * @param UrlInterface $urlBuilder
     * @param WidgetConfig $widgetConfig
     */
    public function __construct(Request $request, WidgetConfig $widgetConfig)
    {
        $this->request = $request;
        $this->widgetConfig = $widgetConfig;
    }

    /**
     * Skip widgets from config
     *
     * @param Subject $subject
     * @param array $result
     * @return mixed
     */
    public function afterGetConfig(Subject $subject, $result)
    {
        $checkPageIdentifier = $this->request->getModuleName() . '/' . $this->request->getControllerName();
        $skipWidgets = [];
        if (self::REQUEST_PAGE_IDENTIFIER === $checkPageIdentifier && isset($result['widget']['types'])) {
            foreach ($result['widget']['types'] as $widgetType => $title) {
                if (!in_array($widgetType, self::SHOW_WIDGETS)) {
                    $skipWidgets[] = $widgetType;
                    unset($result['widget']['types'][$widgetType]);
                }
            }
        }
        if ($skipWidgets) {
            $urlParams = $this->widgetConfig->encodeWidgetsToQuery($skipWidgets);
            $result['widget']['openModalUrl'] .= 'skip_widgets/' . $urlParams . '/';
        }

        return $result;
    }
}
