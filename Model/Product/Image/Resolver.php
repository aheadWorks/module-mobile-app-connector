<?php
namespace Aheadworks\MobileAppConnector\Model\Product\Image;

use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Image\ParamsBuilder;
use Magento\Framework\View\ConfigInterface;
use Magento\Catalog\Model\View\Asset\Placeholder;
use Magento\Catalog\Model\View\Asset\PlaceholderFactory;
use Magento\Catalog\Model\View\Asset\Image as AssetImage;
use Magento\Catalog\Model\View\Asset\ImageFactory as AssetImageFactory;
use Magento\Framework\View\Asset\Repository as ViewAssetFrontendRepository;

/**
 * Class Resolver
 *
 * @package Aheadworks\MobileAppConnector\Model\Product\Image
 */
class Resolver
{
    /**
     * File path fot the case, when product is not defined, or product image is not set
     */
    const DEFAULT_FILE_PATH = 'no_selection';

    /**
     * @var ConfigInterface
     */
    private $presentationConfig;

    /**
     * @var PlaceholderFactory
     */
    private $viewAssetPlaceholderFactory;

    /**
     * @var AssetImageFactory
     */
    private $viewAssetImageFactory;

    /**
     * @var ParamsBuilder
     */
    private $imageParamsBuilder;

    /**
     * @var ViewAssetFrontendRepository
     */
    private $viewAssetFrontendRepository;

    /**
     * @param ConfigInterface $presentationConfig
     * @param PlaceholderFactory $viewAssetPlaceholderFactory
     * @param AssetImageFactory $viewAssetImageFactory
     * @param ParamsBuilder $imageParamsBuilder
     * @param ViewAssetFrontendRepository $viewAssetFrontendRepository
     */
    public function __construct(
        ConfigInterface $presentationConfig,
        PlaceholderFactory $viewAssetPlaceholderFactory,
        AssetImageFactory $viewAssetImageFactory,
        ParamsBuilder $imageParamsBuilder,
        ViewAssetFrontendRepository $viewAssetFrontendRepository
    ) {
        $this->presentationConfig = $presentationConfig;
        $this->viewAssetPlaceholderFactory = $viewAssetPlaceholderFactory;
        $this->viewAssetImageFactory = $viewAssetImageFactory;
        $this->imageParamsBuilder = $imageParamsBuilder;
        $this->viewAssetFrontendRepository = $viewAssetFrontendRepository;
    }

    /**
     * Retrieve view image config
     *
     * @param string $imageId
     * @return array
     */
    public function getViewImageConfig($imageId)
    {
        return $this->presentationConfig
            ->getViewConfig(
                [
                    'area' => 'frontend',
                ]
            )->getMediaAttributes(
                'Magento_Catalog',
                ImageHelper::MEDIA_TYPE_CONFIG_NODE,
                $imageId
            );
    }

    /**
     * Retrieve product image url
     *
     * @param Product|null $product
     * @param string $imageId
     * @return string
     */
    public function getProductImageUrl($product, $imageId)
    {
        $viewImageConfig = $this->getViewImageConfig($imageId);
        $imageMiscParams = $this->imageParamsBuilder->build($viewImageConfig);

        $originalFilePath = null;
        if ($product instanceof Product) {
            $originalFilePath = $product->getData($imageMiscParams['image_type']);
        } else {
            $originalFilePath = self::DEFAULT_FILE_PATH;
        }

        if ($this->isFilePathSet($originalFilePath)) {
            /** @var AssetImage $imageAsset */
            $imageAsset = $this->viewAssetImageFactory->create(
                [
                    'miscParams' => $imageMiscParams,
                    'filePath' => $originalFilePath,
                ]
            );
        } else {
            /** @var Placeholder $imageAsset */
            $imageAsset = $this->viewAssetPlaceholderFactory->create(
                [
                    'type' => $imageMiscParams['image_type'],
                    'assetRepo' => $this->viewAssetFrontendRepository
                ]
            );
        }

        return $imageAsset->getUrl();
    }

    /**
     * Check if file path is set
     *
     * @param string $filePath
     * @return bool
     */
    private function isFilePathSet($filePath)
    {
        return ($filePath !== null && $filePath !== self::DEFAULT_FILE_PATH);
    }
}
