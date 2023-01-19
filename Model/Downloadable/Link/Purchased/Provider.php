<?php

namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased;

use Magento\Downloadable\Model\Link\Purchased as PurchasedLink;
use Magento\Downloadable\Model\Link\PurchasedFactory as PurchasedLinkFactory;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\Collection as PurchasedLinkCollection;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\CollectionFactory as PurchasedLinkCollectionFactory;

/**
 * Class for provider
 */
class Provider
{
    /**
     * @var PurchasedLinkCollectionFactory
     */
    private $purchasedLinkCollectionFactory;

    /**
     * @var PurchasedLinkFactory
     */
    private $purchasedLinkFactory;

    /**
     * @param PurchasedLinkCollectionFactory $purchasedLinkCollectionFactory
     * @param PurchasedLinkFactory $purchasedLinkFactory
     */
    public function __construct(
        PurchasedLinkCollectionFactory $purchasedLinkCollectionFactory,
        PurchasedLinkFactory $purchasedLinkFactory
    ) {
        $this->purchasedLinkCollectionFactory = $purchasedLinkCollectionFactory;
        $this->purchasedLinkFactory = $purchasedLinkFactory;
    }

    /**
     * Retrieve array of purchased links ids for specific customer
     *
     * @param int $customerId
     * @return array
     */
    public function getIds(int $customerId)
    {
        /** @var PurchasedLinkCollection $collection */
        $collection = $this->purchasedLinkCollectionFactory->create();
        $collection
            ->addFieldToFilter('customer_id', $customerId)
            ->addOrder('created_at', PurchasedLinkCollection::SORT_ORDER_DESC);
        $ids = [];
        /** @var PurchasedLink $item */
        foreach ($collection->getItems() as $item) {
            $ids[] = $item->getId();
        }
        return $ids;
    }

    /**
     * Retrieve purchased link by id
     *
     * @param int $purchasedLinkId
     * @return PurchasedLink
     */
    public function getById(int $purchasedLinkId)
    {
        /** @var PurchasedLink $purchasedLink */
        $purchasedLink = $this->purchasedLinkFactory->create();
        $purchasedLink->load($purchasedLinkId);
        return $purchasedLink;
    }
}
