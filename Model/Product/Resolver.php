<?php
namespace Aheadworks\MobileAppConnector\Model\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Catalog\Model\Product;

/**
 * Class Resolver
 *
 * @package Aheadworks\MobileAppConnector\Model\Product
 */
class Resolver
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var OrderItemRepositoryInterface
     */
    private $orderItemRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param OrderItemRepositoryInterface $orderItemRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        OrderItemRepositoryInterface $orderItemRepository
    ) {
        $this->productRepository = $productRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * Retrieve product by corresponding order item
     *
     * @param $orderItemId
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
     * @param $orderItemId
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
}
