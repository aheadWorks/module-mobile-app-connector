<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item;

use Aheadworks\MobileAppConnector\Model\ResourceModel\AbstractCollection;
use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\Item as PurchasedLinkItemResourceModel;

/**
 * Class for Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Init resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            PurchasedLinkItemModel::class,
            PurchasedLinkItemResourceModel::class
        );
    }
}
