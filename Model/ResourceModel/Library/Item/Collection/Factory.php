<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection;

use Magento\Downloadable\Model\Link\Purchased\Item;
use Magento\Framework\ObjectManagerInterface;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection as LibraryItemCollection;
use Aheadworks\MobileAppConnector\Model\ResourceModel\AbstractCollection;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Provider as PurchasedLinkProvider;
use Magento\Framework\App\ResourceConnection;

/**
 * Class for Factory
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
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var PurchasedLinkProvider
     */
    private $purchasedLinkProvider;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param ResourceConnection $resourceConnection
     * @param PurchasedLinkProvider $purchasedLinkProvider
     * @param string $instanceName
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ResourceConnection $resourceConnection,
        PurchasedLinkProvider $purchasedLinkProvider,
        $instanceName = LibraryItemCollection::class
    ) {
        $this->objectManager = $objectManager;
        $this->resourceConnection = $resourceConnection;
        $this->purchasedLinkProvider = $purchasedLinkProvider;
        $this->instanceName = $instanceName;
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
                'main_table.purchased_id',
                ['in' => $purchasedLinkIds]
            )->addFieldToFilter(
                'status',
                ['in' => [Item::LINK_STATUS_AVAILABLE]]
            )
            ->setOrder(
                'item_id',
                AbstractCollection::SORT_ORDER_DESC
            );
        return $collection;
    }
}
