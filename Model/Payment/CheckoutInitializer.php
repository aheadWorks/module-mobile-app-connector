<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment;

use Magento\Quote\Model\Quote;
use Magento\Checkout\Model\Session as CheckoutSession;
use Aheadworks\MobileAppConnector\Model\Payment\CustomerManagement;

/**
 * Class CheckoutInitializer to initialize checkout processes
 */
class CheckoutInitializer
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var CustomerManagement
     */
    private $customerManagement;

    /**
     * CheckoutInitializer constructor.
     *
     * @param CheckoutSession $checkoutSession
     * @param CustomerManagement $customerManagement
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        CustomerManagement $customerManagement
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->customerManagement = $customerManagement;
    }

    /**
     * Initialize customer session by quote
     *
     * @param Quote $quote
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function initializeCustomerSession(Quote $quote): void
    {
        if (!$quote->getCustomerIsGuest()) {
            if (!$this->customerManagement->isCustomerLoggedIn($quote->getCustomer())) {
                $this->customerManagement->authorizeCustomer(
                    $quote->getCustomer()->getEmail(),
                    $quote->getStore()->getWebsiteId()
                );
            }
        } else {
            $this->customerManagement->logoutCustomer();
        }
    }

    /**
     * Initialize checkout session by quote
     *
     * @param Quote $quote
     * @return void
     */
    public function initializeCheckoutSession(Quote $quote): void
    {
        if ($this->checkoutSession->getQuoteId() !== (int)$quote->getId()) {
            $this->checkoutSession->clearStorage();
            $this->checkoutSession->replaceQuote($quote);
        }

        $this->checkoutSession->setAwMacPaymentProcessFlag(true);
    }
}
