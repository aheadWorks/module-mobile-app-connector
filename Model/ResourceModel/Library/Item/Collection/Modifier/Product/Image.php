<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier\Product;

use Aheadworks\MobileAppConnector\Model\Product\Image\Resolver as ProductImageResolver;
use Aheadworks\MobileAppConnector\Model\Product\Resolver as ProductResolver;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;

/**
 * Class for Image
 */
class Image implements ModifierInterface
{
    /**
     * @var ProductImageResolver
     */
    private $productImageResolver;

    /**
     * @var ProductResolver
     */
    private $productResolver;

    /**
     * @param ProductImageResolver $productImageResolver
     * @param ProductResolver $productResolver
     */
    public function __construct(
        ProductImageResolver $productImageResolver,
        ProductResolver $productResolver
    ) {
        $this->productImageResolver = $productImageResolver;
        $this->productResolver = $productResolver;
    }

    /**
     * Modify data
     *
     * @param string $item
     * @return string
     */
    public function modifyData($item)
    {
        $orderItemId = $item->getData(LibraryItemInterface::ORDER_ITEM_ID);
        $product = $this->productResolver->getProductByOrderItem($orderItemId);
        $item->setData(
            LibraryItemInterface::PRODUCT_IMAGE_URL,
            $this->productImageResolver->getProductImageUrl(
                $product,
                'category_page_grid'
            )
        );
        return $item;
    }
}
