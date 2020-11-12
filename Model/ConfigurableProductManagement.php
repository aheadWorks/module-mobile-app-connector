<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\ConfigurableProductManagementInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ConfigurableProduct\Model\LinkManagement;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\InputException;
use Aheadworks\MobileAppConnector\Model\Product\Resolver;

/**
 * Class ConfigurableProductManagement
 * @package Aheadworks\MobileAppConnector\Model
 */
class ConfigurableProductManagement implements ConfigurableProductManagementInterface
{
    /**#@+
     * Constants defined for keys of the data array.
     */
    const VARIATION = 'variation';
    const OPTIONS ='configurable_options';

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
    private $productResolver;

    /**
     * Constructor
     *
     * @param ProductRepositoryInterface $productRepository
     * @param LinkManagement $linkManagement
     * @param Resolver $productResolver
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        LinkManagement $linkManagement,
        Resolver $productResolver

    ) {
        $this->productRepository = $productRepository;
        $this->linkManagement = $linkManagement;
        $this->productResolver = $productResolver;
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

        if ($product->getTypeId() != Configurable::TYPE_CODE) {
            return [];
        }
        $childrenList = $this->linkManagement->getChildren($sku);
        $productAttributeOptions = $product->getTypeInstance()->getConfigurableAttributesAsArray($product);
        $variants = [];
        foreach ($childrenList as $key => $child) {
            $variants[$key] = ['product' => $child->getData()];
        }

        $data = [
                Resolver::ID => $product->getId(),
                ProductInterface::SKU => $product->getSku(),
                ProductInterface::NAME => $product->getName(),
                ProductInterface::PRICE => $product->getPrice(),
                ProductInterface::TYPE_ID => $product->getTypeId(),
                Resolver::MIN_PRICE => $this->productResolver->getMinimumPrice($product),
                Resolver::MAX_PRICE => $this->productResolver->getMaximumPrice($product),
                Resolver::FINAL_PRICE => $product->getFinalPrice(),
                Resolver::IMAGE => $this->productResolver->getProductImageUrl($product),
                self::OPTIONS => $productAttributeOptions,
                self::VARIATION => $variants
            ];

        $productsData[] = $data;
        return $productsData;
    }

}
