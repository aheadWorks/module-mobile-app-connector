<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\ConfigurableProductManagementInterface;
use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ConfigurableProduct\Model\LinkManagement;
use Magento\Framework\Exception\InputException;

/**
 * Class ConfigurableProductManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class ConfigurableProductManagement implements ConfigurableProductManagementInterface
{
    /**#@+
     * Constants defined for keys of the data array.
     */
    const DATA = 'data';
    const VARIATION = 'variation';
    const OPTIONS ='configurable_options';
    const ID = 'id';
    const MIN_PRICE = 'min_price';
    const MAX_PRICE = 'max_price';
    const FINAL_PRICE = 'final_price';
    const IMAGE = 'product_image';

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var LinkManagement
     */
    private $linkManagement;

    /**
     * @var Resolver
     */
    protected $imageResolver;

    /**
     * Constructor
     *
     * @param ProductRepositoryInterface $productRepository
     * @param LinkManagement $linkManagement
     * @param Resolver $imageResolver
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        LinkManagement $linkManagement,
        Resolver $imageResolver
    ) {
        $this->productRepository = $productRepository;
        $this->linkManagement = $linkManagement;
        $this->imageResolver = $imageResolver;
    }

    /**
     * @inheritdoc
     */
    public function getChildren($sku)
    {
        if (empty($sku) || !isset($sku)) {
            throw new InputException(__('Sku required'));
        }
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->productRepository->get($sku);

        if ($product->getTypeId() != \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            return [];
        }
        $childrenList = $this->linkManagement->getChildren($sku);
        $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        $options = [];
        foreach ($productAttributeOptions as $productAttribute) {
            $options[] = $productAttribute;
        }

        $variants = [];
        foreach ($childrenList as $key => $child) {
            $variants[$key] = ['product' => $child->getData()];
        }

        $data = [
                self::ID => $product->getId(),
                ProductInterface::SKU => $product->getSku(),
                ProductInterface::NAME => $product->getName(),
                ProductInterface::PRICE => $product->getPrice(),
                ProductInterface::TYPE_ID => $product->getTypeId(),
                self::MIN_PRICE => $this->getMinimumPrice($product),
                self::MAX_PRICE => $this->getMaximumPrice($product),
                self::FINAL_PRICE => $product->getFinalPrice(),
                self::IMAGE => $this->getProductImageUrl($product),
                self::OPTIONS => $options,
                self::VARIATION => $variants
            ];

        $productsData[] = $data;
        return $productsData;
    }
    /**
     * @param ProductInterface $product
     * @return string $image
     */
    protected function getProductImageUrl($product)
    {
        return $this->imageResolver->getProductImageUrl($product, 'category_page_grid');
    }

    /**
     * Return product min price
     * @param ProductInterface $product
     * @return double
     */
    private function getMinimumPrice($product)
    {
        return $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
    }

    /**
     * Return product max price
     * @param ProductInterface $product
     * @return double
     */
    private function getMaximumPrice($product)
    {
        return $product->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue();
    }
}
