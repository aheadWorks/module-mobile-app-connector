<?php
namespace Aheadworks\MobileAppConnector\Model\Product;

use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver as ImageResolver;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Sales\Api\OrderItemRepositoryInterface;

/**
 * Class for Resolver
 */
class Resolver
{
    /**#@+
     * Constants defined for keys of the data array.
     */
    public const ID = 'id';
    public const MIN_PRICE = 'min_price';
    public const MAX_PRICE = 'max_price';
    public const FINAL_PRICE = 'final_price';
    public const IMAGE = 'product_image';

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var OrderItemRepositoryInterface
     */
    private $orderItemRepository;

    /**
     * @var ImageResolver
     */
    protected $imageResolver;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param OrderItemRepositoryInterface $orderItemRepository
     * @param ImageResolver $imageResolver
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        ImageResolver $imageResolver
    ) {
        $this->productRepository = $productRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->imageResolver = $imageResolver;
    }

    /**
     * Retrieve product by corresponding order item
     *
     * @param int $orderItemId
     * @return Product|null
     */
    public function getProductByOrderItem($orderItemId)
    {
        try {
            $orderItem = $this->orderItemRepository->get($orderItemId);
            /** @var Product $product */
            $product = $this->productRepository->getById($orderItem->getProductId());
        } catch (\Exception $exception) {
            $product = null;
        }
        return $product;
    }

    /**
     * Retrieve product name from corresponding order item
     *
     * @param int $orderItemId
     * @return string
     */
    public function getProductNameByOrderItem($orderItemId)
    {
        try {
            $orderItem = $this->orderItemRepository->get($orderItemId);
            $productName = $orderItem->getName();
        } catch (\Exception $exception) {
            $productName = '';
        }
        return $productName;
    }

    /**
     * Get Product ImageUrl
     *
     * @param ProductInterface $product
     * @return string $image
     */
    public function getProductImageUrl($product)
    {
        return $this->imageResolver->getProductImageUrl($product, 'category_page_grid');
    }

    /**
     * Return product min price
     *
     * @param ProductInterface $product
     * @return double
     */
    public function getMinimumPrice($product)
    {
        return $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
    }

    /**
     * Return product max price
     *
     * @param ProductInterface $product
     * @return double
     */
    public function getMaximumPrice($product)
    {
        return $product->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue();
    }
}
