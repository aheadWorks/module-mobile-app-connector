<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Plugin\Magento\Checkout\Controller\Onepage;

use Magento\Checkout\Controller\Onepage\Success as Subject;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\JsonFactory as JsonResultFactory;

/**
 * Class Plugin for Success Page
 */
class SuccessPlugin
{
    /**
     * @var JsonResultFactory
     */
    private $jsonResultFactory;

    /**
     * SuccessPlugin constructor.
     *
     * @param JsonResultFactory $jsonResultFactory
     */
    public function __construct(JsonResultFactory $jsonResultFactory)
    {
        $this->jsonResultFactory = $jsonResultFactory;
    }

    /**
     * Logout customer and pass order's data
     *
     * @param Subject $subject
     * @param ResultInterface $result
     * @return ResultInterface
     */
    public function afterExecute(Subject $subject, ResultInterface $result)
    {
        $checkoutSession = $subject->getOnepage()->getCheckout();
        if ($checkoutSession->getAwMacPaymentProcess()) {
            $customerSession = $subject->getOnepage()->getCustomerSession();

            $resultOrderData['order'] = [
                'increment_id' => $checkoutSession->getLastRealOrder()->getIncrementId(),
                'order_id' => $checkoutSession->getLastRealOrder()->getId()
            ];

            if ($customerSession->isLoggedIn()) {
                $customerSession->logout();
            }

            $checkoutSession->unsAwMacPaymentProcess();

            return $this->jsonResultFactory->create()->setData($resultOrderData);
        }

        return $result;
    }
}
