<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

/**
 * Class PaymentLayoutProcessor
 */
class PaymentLayoutProcessor implements LayoutProcessorInterface
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * PaymentLayoutProcessor constructor.
     *
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(CheckoutSession $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Remove unnecessary components to optimize the mobile payment page
     *
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout): array
    {
        if ($this->checkoutSession->getAwMacPaymentProcessFlag()) {
            unset($jsLayout["components"]["checkout"]["children"]["sidebar"]["children"]["shipping-information"],
                $jsLayout["components"]["checkout"]["children"]["sidebar"]["children"]["summary"]["children"]
                ["cart_items"]
            );
        }
        return $jsLayout;
    }
}
