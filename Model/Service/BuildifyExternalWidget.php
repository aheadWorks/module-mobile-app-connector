<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Aheadworks\Buildify\Api\Data\EntityFieldInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\BlockInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\View\LayoutInterface;

/**
 * Class service BuildifyExternalWidget for adding additional data to widget
 */
class BuildifyExternalWidget
{
    /**
     * @var Json
     */
    private $serializer;

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * BuildifyExternalWidget constructor.
     *
     * @param Json $serializer
     * @param LayoutInterface $layout
     * @param LoggerInterface $logger
     */
    public function __construct(
        Json $serializer,
        LayoutInterface $layout,
        LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
        $this->layout = $layout;
        $this->logger = $logger;
    }

    /**
     * Update/Add additional widget's content
     *
     * @param EntityFieldInterface $content
     * @return EntityFieldInterface
     */
    public function addAdditionalContent(EntityFieldInterface $content): EntityFieldInterface
    {
        if ($content->getData('editor_config')) {
            $config = $content->getData('editor_config');
            foreach ($config as $configKey => $configItem) {
                foreach ($configItem['elements'] as $configItemKey => $configItemElement) {
                    if (isset($configItemElement['elements'])) {
                        foreach ($configItemElement['elements'] as $configItemElementKey => $buildifyWidget) {
                            if (($buildifyWidget['widgetType'] === 'external-widget') &&
                                isset($buildifyWidget['settings']['wp_widget']['content'])) {
                                $widgetConfigContent = $buildifyWidget['settings']['wp_widget']['content'];
                                $widgetConfig = $this->widgetContentToArray($widgetConfigContent);

                                $additionalData = $this->getAdditionalData($widgetConfig);
                                foreach ($additionalData as $additionalDataKey => $additionalDataVal) {
                                    $config[$configKey]['elements'][$configItemKey]['elements'][$configItemElementKey]
                                    ['settings']['wp_widget']['preview'][$additionalDataKey] = $additionalDataVal;
                                }
                            }
                        }
                    }
                }
            }
            $content->setData('editor_config', $config);
        }
        return $content;
    }

    /**
     * Widget content convert to array
     *
     * @param string $widgetConfigContent
     * @return array
     */
    private function widgetContentToArray(string $widgetConfigContent): array
    {
        $widgetConfig = [];

        preg_match_all('/(?:[^"]|"")*/i', $widgetConfigContent, $matches);
        if (isset($matches[0])) {
            $matches = array_values(array_diff($matches[0], [""]));
            $matches[0] = str_replace("{{widget ", "", $matches[0]);
            unset($matches[array_key_last($matches)]);

            $widgetConfigKey = "";
            foreach ($matches as $key => $match) {
                if (($key === 0) || (!is_float($key/2))) {
                    $widgetConfigKey = trim(str_replace("=", "", $match));
                } else {
                    $widgetConfig[$widgetConfigKey] = $match;
                }

            }
        }

        return $widgetConfig;
    }

    /**
     * Get additional widget data
     *
     * @param array $widgetConfig
     * @return array
     */
    private function getAdditionalData(array $widgetConfig): array
    {
        $result = [];
        try {
            $widgetType = $widgetConfig['type'];
            unset($widgetConfig['type']);

            /** @var BlockInterface $blockWidget */
            $blockWidget = $this->layout->createBlock(
                $widgetType,
                '',
                ['data' => $widgetConfig]
            )->setData('area', 'frontend');
            $htmlWidget = $blockWidget->toHtml();
            $skuProducts = $blockWidget->getData('sku_products') ?: [];
            $skuProducts = $this->serializer->serialize($skuProducts);

            $result['html'] = $this->serializer->serialize($htmlWidget);
            $result['sku_products'] = str_replace('"', "'", $skuProducts);
        } catch (\Exception $exception) {
            $this->logger->error($exception);
        }

        return $result;
    }
}
