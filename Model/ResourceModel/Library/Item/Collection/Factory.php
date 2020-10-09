<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection;

use Magento\Downloadable\Model\Link\Purchased\Item;
use Magento\Framework\ObjectManagerInterface;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection as LibraryItemCollection;
use Aheadworks\MobileAppConnector\Model\ResourceModel\AbstractCollection;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Provider as PurchasedLinkProvider;
use Magento\Framework\App\ResourceConnection;
/**
 * Class Factory
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection
 */
class Factory
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

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
        ResourceConnection $resourceConnection,
        $instanceName = LibraryItemCollection::class
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
        $this->purchasedLinkProvider = $purchasedLinkProvider;
        $this->resourceConnection = $resourceConnection;
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
        $collection->getSelect()
                    ->joinLeft( array('purches_item'=>$this->resourceConnection->getTableName('downloadable_link_purchased')),
                               'purches_item.purchased_id = main_table.purchased_id', array('purches_item.product_name'))
                    ->joinLeft(array('val'=>$this->resourceConnection->getTableName('catalog_product_entity_media_gallery_value')),
                                'val.entity_id = main_table.product_id',array('val.value_id'))
                     ->joinLeft(array('gal'=>$this->resourceConnection->getTableName('catalog_product_entity_media_gallery')),
                                'gal.value_id = val.value_id',array('product_image_url' =>'gal.value')
                    );
   // echo $collection->getSelect()->__toString();die();

        $collection
            ->addFieldToFilter(
                'main_table.purchased_id',
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
