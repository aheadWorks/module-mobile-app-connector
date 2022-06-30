<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\Data\OrderItemExtensionFactory;
use Magento\Catalog\Model\Product;

/**
 * Class OrderExtension for adding additional data to order
 */
class OrderExtension
{
    const DISPLAY_PRODUCT_DETAIL_DATA = [
        'type_id',
        'sku',
        'media_gallery',
        'status',
        'name',
        'custom_attributes',
        'extension_attributes',
        'product_links'
    ];

    /**
     * @var OrderItemExtensionFactory
     */
    protected $orderItemExtensionFactory;

    /**
     * OrderExtension constructor.
     *
     * @param OrderItemExtensionFactory $orderItemExtensionFactory
     */
    public function __construct(OrderItemExtensionFactory $orderItemExtensionFactory)
    {
        $this->orderItemExtensionFactory = $orderItemExtensionFactory;
    }

    /**
     * Add product detail data to order
     *
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function addProductDetailData(OrderInterface $order): OrderInterface
    {
        foreach ($order->getItems() as $orderItem) {
            /** @var Product $product */
            $product = $orderItem->getProduct();
            if ($product) {
                /** @var OrderItemInterface $extensionAttributes */
                $extensionAttributes = $orderItem->getExtensionAttributes();
                if (!$extensionAttributes) {
                    $extensionAttributes = $this->orderItemExtensionFactory->create();
                }

                // display only the necessary data
                foreach ($product->getData() as $dataKey => $dataVal) {
                    if (!in_array($dataKey, self::DISPLAY_PRODUCT_DETAIL_DATA)) {
                        $product->unsetData($dataKey);
                    }
                }

                $extensionAttributes->setAwProductDetail($product);
                $orderItem->setExtensionAttributes($extensionAttributes);
            }
        }
        return $order;
    }
}
