<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Plugin\Magento\Sales\Api;

use Magento\Sales\Api\OrderRepositoryInterface as Subject;
use Magento\Sales\Api\Data\OrderInterface;
use Aheadworks\MobileAppConnector\Model\Service\OrderExtension;
use Magento\Sales\Api\Data\OrderSearchResultInterface;

/**
 * Class OrderRepositoryInterfacePlugin add additional data to order
 */
class OrderRepositoryInterfacePlugin
{
    /**
     * @var OrderExtension
     */
    protected $orderExtension;

    /**
     * OrderRepositoryInterfacePlugin constructor.
     * @param OrderExtension $orderExtension
     */
    public function __construct(OrderExtension $orderExtension)
    {
        $this->orderExtension = $orderExtension;
    }

    /**
     * After get order
     *
     * @param Subject $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(Subject $subject, OrderInterface $order): OrderInterface
    {
        return $this->orderExtension->addProductDetailData($order);
    }

    /**
     * After get order's list
     *
     * @param Subject $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(Subject $subject, OrderSearchResultInterface $searchResult): OrderSearchResultInterface
    {
        foreach ($searchResult->getItems() as $order) {
            $this->afterGet($subject, $order);
        }
        return $searchResult;
    }
}
