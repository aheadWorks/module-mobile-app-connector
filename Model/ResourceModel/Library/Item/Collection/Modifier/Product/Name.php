<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier\Product;

use Aheadworks\MobileAppConnector\Model\Product\Resolver as ProductResolver;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;

/**
 * Class for Name
 */
class Name implements ModifierInterface
{
    /**
     * @var ProductResolver
     */
    private $productResolver;

    /**
     * @param ProductResolver $productResolver
     */
    public function __construct(
        ProductResolver $productResolver
    ) {
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
        $item->setData(
            LibraryItemInterface::PRODUCT_NAME,
            $this->productResolver->getProductNameByOrderItem($orderItemId)
        );
        return $item;
    }
}
