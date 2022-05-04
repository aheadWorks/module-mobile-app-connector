<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Magento\Downloadable\Model\Link\Purchased\Item as PurchasedLinkItemModel;
use Magento\Downloadable\Model\Link\Purchased\ItemFactory as PurchasedLinkItemModelFactory;

/**
 * Class Provider
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Provider
{
    /**
     * @var PurchasedLinkItemModelFactory
     */
    private $purchasedLinkItemModelFactory;

    /**
     * @param PurchasedLinkItemModelFactory $purchasedLinkItemModelFactory
     */
    public function __construct(PurchasedLinkItemModelFactory $purchasedLinkItemModelFactory)
    {
        $this->purchasedLinkItemModelFactory = $purchasedLinkItemModelFactory;
    }

    /**
     * Retrieve item by its link hash
     *
     * @param string $linkHash
     * @return PurchasedLinkItemModel
     */
    public function getByLinkHash($linkHash)
    {
        /** @var PurchasedLinkItemModel $purchasedLinkItem */
        $purchasedLinkItem = $this->purchasedLinkItemModelFactory->create();
        $purchasedLinkItem->load($linkHash, 'link_hash');
        return $purchasedLinkItem;
    }
}
