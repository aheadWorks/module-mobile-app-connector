<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\CustomerOrderInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Config;

class CustomerOrder implements CustomerOrderInterface
{

    /**
     * @var OrderRepositoryInterface
     */
    public $_orderRepository;

    /**
     * CustomerOrder constructor.
     *
     * @param Order $order
     */
    protected $order;

    /**
     * @var OrderInterface[]
     */
    protected $registry = [];

    /**
     * Order config
     * @var Config
     */
    public $orderConfig;


    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Config $orderConfig,
        Order $order
    ) {
        $this->_orderRepository = $orderRepository;
        $this->order = $order;
        $this->orderConfig = $orderConfig;
    }

    /**
     * @param int $id The order ID.
     * @return OrderInterface[]
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function get(int $id)
    {
        if (empty($id) || !isset($id) || $id == "") {
            throw new InputException(__('Id required'));
        }

        if (!isset($this->registry[$id])) {
            $entity = $this->_orderRepository->get($id);

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

        $_orders = $this->order->getCollection()
                            ->addAttributeToFilter('customer_id', $customerId)
                            ->addFieldToFilter('status', ['in' => $this->orderConfig->getVisibleOnFrontStatuses()])
                            ->setOrder('created_at', 'desc');

        $data=[];
        $i=0;
        foreach ($_orders as $_order) {
            $data[$i]['increment_id']=$_order->getIncrementId();
            $data[$i]['created_at']=$_order->getCreatedAt();
            $data[$i]['ship_to']= $_order->getShippingAddress()->getName();
            $data[$i]['grand_total']=$_order->getGrandTotal();
            $data[$i]['status']=$_order->getStatusLabel();
            $data[$i]['id']=$_order->getId();
            $i++;
        }
        return $data;
    }
}
