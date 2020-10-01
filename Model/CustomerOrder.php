<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\CustomerOrderInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class CustomerOrder
 * @package Aheadworks\MobileAppConnector\Model
 */
class CustomerOrder implements CustomerOrderInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    public $orderRepository;

    /**
     * @var $registry[]
     */
    protected $registry = [];

    /**
     * @var SearchCriteriaBuilder
     */
    public $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    public $filterBuilder;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @param int $id The order ID.
     * @return \Magento\Sales\Api\Data\OrderInterface|mixed $registry
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function get(int $id)
    {
        if (empty($id) || !isset($id) || $id == "") {
            throw new InputException(__('Id required'));
        }
        if (!isset($this->registry[$id])) {
            $entity = $this->orderRepository->get($id);
            if (!$entity->getEntityId()) {
                throw new NoSuchEntityException(
                    __("The entity that was requested doesn't exist. Verify the entity and try again.")
                );
            }
            $this->registry[$id] = $entity;
        }
        return $this->registry[$id];
    }

    /**
     * Returns orders data to user
     *
     * @param $customerId
     * @return array order array collection.
     * @throws InputException
     * @api
     */
    public function getList($customerId)
    {
        if (empty($customerId) || !isset($customerId) || $customerId == "") {
            throw new InputException(__('Id required'));
        }
        $filters = [
            $this->filterBuilder->setField('customer_id')->setValue($customerId)->create()
        ];
        $searchCriteria = $this->searchCriteriaBuilder->addFilters($filters)->create();
        $this->orders = $this->orderRepository->getList($searchCriteria);

        $data=[];
        $i=0;
        foreach ($this->orders as $order) {
            $data[$i][self::ORDER_INCREMENT_ID] = $order['increment_id'];
            $data[$i][self::ORDER_CREATED_AT] = $order['created_at'];
            $data[$i][self::ORDER_SHIP_TO] = $order->getShippingAddress()->getName();
            $data[$i][self::ORDER_GRAND_TOTAL] = $order['grand_total'];
            $data[$i][self::ORDER_STATUS] = $order['status'];
            $data[$i][self::ORDER_ID] = $order['entity_id'];
            $i++;
        }
        return $data;
    }
}
