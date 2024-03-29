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
use Magento\Framework\Validator\Exception as ValidatorException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class for customer order
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
    private const SHIP_TO = 'ship_to';

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
     * Get customer id
     *
     * @param int $customerId
     * @param int $id
     * @return int
     */
    public function get(int $customerId, int $id)
    {
        if (empty($id) || !isset($id) || $id == "") {
            throw new InputException(__('Id required'));
        }
        $entity = $this->orderRepository->get($id);
        if ($entity->getCustomerId() != $customerId) {
            throw new ValidatorException(
                __('This Order id does not belongs to customer')
            );
        }
        return $entity;
    }

    /**
     * Get let
     *
     * @param int $customerId
     * @return string
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
                   self::SHIP_TO                 => $this->getShipName($order),
                   OrderInterface::GRAND_TOTAL   => $order->getGrandTotal(),
                   OrderInterface::STATUS        => $order->getStatus(),
                   OrderInterface::ENTITY_ID     => $order->getEntityId(),
                ];
            $orderData[] = $data;
        }
        return $orderData;
    }

    /**
     * Get shipping name
     *
     * @param OrderInterface $order
     * @return string
     */
    private function getShipName($order)
    {
        return ($order->getShippingAddress() ? $order->getShippingAddress()->getName() : "");
    }
}
