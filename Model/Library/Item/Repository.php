<?php
namespace Aheadworks\MobileAppConnector\Model\Library\Item;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterfaceFactory;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemSearchResultsInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemSearchResultsInterfaceFactory;
use Aheadworks\MobileAppConnector\Api\LibraryItemRepositoryInterface;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Factory as LibraryItemCollectionFactory;
use Exception;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\DataObject;

/**
 * Class Repository
 *
 * @package Aheadworks\MobileAppConnector\Model\Library\Item
 */
class Repository implements LibraryItemRepositoryInterface
{
    /**
     * @var LibraryItemInterfaceFactory
     */
    private $libraryItemFactory;

    /**
     * @var LibraryItemCollectionFactory
     */
    private $libraryItemCollectionFactory;

    /**
     * @var LibraryItemSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @param LibraryItemInterfaceFactory $libraryItemFactory
     * @param LibraryItemCollectionFactory $libraryItemCollectionFactory
     * @param LibraryItemSearchResultsInterfaceFactory $searchResultsFactory
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        LibraryItemInterfaceFactory $libraryItemFactory,
        LibraryItemCollectionFactory $libraryItemCollectionFactory,
        LibraryItemSearchResultsInterfaceFactory $searchResultsFactory,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->libraryItemFactory = $libraryItemFactory;
        $this->libraryItemCollectionFactory = $libraryItemCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(int $customerId)
    {
        /** @var LibraryItemSearchResultsInterface $searchResults */
        try {
            $collection = $this->libraryItemCollectionFactory->create($customerId);
            $this->extensionAttributesJoinProcessor->process($collection, LibraryItemInterface::class);
            $searchResults = $this->searchResultsFactory->create();
            $searchResults->setTotalCount($collection->getSize());
            $libraryItems = [];
            foreach ($collection->getItems() as $dataObject) {
                $libraryItems[] = $this->getLibraryItem($dataObject);
            }
            $searchResults->setItems($libraryItems);
        } catch (Exception $exception) {
            $searchResults->setTotalCount(0);
        }
        return $searchResults;
    }

    /**
     * Retrieves library item from data object
     *
     * @param DataObject $dataObject
     * @return LibraryItemInterface
     */
    private function getLibraryItem(DataObject $dataObject)
    {
        $object = $this->libraryItemFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $object,
            $dataObject->getData(),
            LibraryItemInterface::class
        );
        return $object;
    }
}
