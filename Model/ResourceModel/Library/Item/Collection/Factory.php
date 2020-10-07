<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection;

use Magento\Downloadable\Model\Link\Purchased\Item;
use Magento\Framework\ObjectManagerInterface;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection as LibraryItemCollection;
use Aheadworks\MobileAppConnector\Model\ResourceModel\AbstractCollection;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Provider as PurchasedLinkProvider;

/**
 * Class Factory
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection
 */
class Factory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    private $objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * @var PurchasedLinkProvider
     */
    private $purchasedLinkProvider;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param PurchasedLinkProvider $purchasedLinkProvider
     * @param string $instanceName
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        PurchasedLinkProvider $purchasedLinkProvider,
        $instanceName = LibraryItemCollection::class
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
        $this->purchasedLinkProvider = $purchasedLinkProvider;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param int $customerId
     * @param array $data
     * @return AbstractCollection
     */
    public function create(
        $customerId,
        array $data = []
    ) {

        /** @var AbstractCollection $collection */
        $collection = $this->objectManager->create($this->instanceName, $data);
        $purchasedLinkIds = $this->purchasedLinkProvider->getIds($customerId);
        if (empty($purchasedLinkIds)) {
            $purchasedLinkIds = [null];
        }

        $collection
            ->addFieldToFilter(
                'purchased_id',
                ['in' => $purchasedLinkIds]
            )->addFieldToFilter(
                'status',
                ['in' => [Item::LINK_STATUS_AVAILABLE]]
            )
            ->addFieldToFilter(
                'link_file',
                ['regexp' => '(\.pdf$)|(\.PDF$)|(\.MP3$)|(\.mp3$)|(\.MP4$)|(\.mp4$)']
            )
             ->setOrder(
                'item_id',
                AbstractCollection::SORT_ORDER_DESC
            );
        return $collection;
    }
}
