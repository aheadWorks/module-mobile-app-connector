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
use Magento\Sales\Api\Data\OrderInterface;
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
     * @var SearchCriteriaBuilder
     */
    public $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    public $filterBuilder;

    /*
     * SHIP TO.
     */
    const SHIP_TO = 'ship_to';

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
     * @return OrderInterface
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
                throw  NoSuchEntityException::singleField('id', $id);
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
            $this->filterBuilder->setField(OrderInterface::CUSTOMER_ID)->setValue($customerId)->create()
        ];
        $searchCriteria = $this->searchCriteriaBuilder->addFilters($filters)->create();
        $orders = $this->orderRepository->getList($searchCriteria)->getItems();
        $orderData = [];
        foreach ($orders as $order) {
            $data = [
                   OrderInterface::INCREMENT_ID  => $order->getIncrementId(),
                   OrderInterface::CREATED_AT    => $order->getCreatedAt(),
                   self::SHIP_TO                 => $order->getShippingAddress()->getName(),
                   OrderInterface::GRAND_TOTAL   => $order->getGrandTotal(),
                   OrderInterface::STATUS        => $order->getStatus(),
                   OrderInterface::ENTITY_ID     => $order->getEntityId(),
                ];
            $orderData[] = $data;
        }
        return $orderData;
    }
}
