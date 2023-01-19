<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Plugin\AwBuildify\Model\ConfigProvider;

use Aheadworks\Buildify\Model\ConfigProvider\WidgetConfigProvider as Subject;
use Magento\Framework\App\Request\Http as Request;
use Magento\Widget\Model\Widget\Config as WidgetConfig;

/**
 * Class Plugin for WidgetConfigProvider
 */
class WidgetConfigProviderPlugin
{
    public const REQUEST_PAGE_IDENTIFIER = 'mobileappconnector/homepage';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var WidgetConfig
     */
    private $widgetConfig;

    /**
     * @var array
     */
    private $showWidgets;

    /**
     * WidgetConfigProviderPlugin constructor.
     *
     * @param Request $request
     * @param WidgetConfig $widgetConfig
     * @param array $showWidgets
     * @return void
     */
    public function __construct(Request $request, WidgetConfig $widgetConfig, array $showWidgets = [])
    {
        $this->request = $request;
        $this->widgetConfig = $widgetConfig;
        $this->showWidgets = $showWidgets;
    }

    /**
     * Skip widgets from config
     *
     * @param Subject $subject
     * @param array $result
     * @return array
     */
    public function afterGetConfig(Subject $subject, array $result): array
    {
        $checkPageIdentifier = $this->request->getModuleName() . '/' . $this->request->getControllerName();
        $skipWidgets = [];
        if (self::REQUEST_PAGE_IDENTIFIER === $checkPageIdentifier &&
            isset($result['widget']['types']) &&
            $this->showWidgets
        ) {
            foreach ($result['widget']['types'] as $widgetType => $title) {
                if (!in_array($widgetType, $this->showWidgets)) {
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
