<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection as FrameworkAbstractCollection;
use Magento\Framework\DataObject;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface as CollectionModifierInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class for AbstractCollection
 */
abstract class AbstractCollection extends FrameworkAbstractCollection
{
    /**
     * @var CollectionModifierInterface
     */
    protected $modifier;

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param CollectionModifierInterface $modifier
     * @param AdapterInterface $connection
     * @param AbstractDb $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        CollectionModifierInterface $modifier,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->modifier = $modifier;
    }

    /**
     * After load
     *
     * @return string
     */
    protected function _afterLoad()
    {
        $this->modifyItemsData();
        return parent::_afterLoad();
    }

    /**
     * Modify items data
     *
     * @return void
     */
    protected function modifyItemsData()
    {
        /** @var DataObject $item */
        foreach ($this as $item) {
            $item = $this->modifier->modifyData($item);
        }
    }
}
