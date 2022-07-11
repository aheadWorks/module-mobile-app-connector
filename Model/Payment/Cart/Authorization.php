<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment\Cart;

use Aheadworks\MobileAppConnector\Model\Payment\Cart\Validator as CartValidator;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\CustomerFactory;
use Magento\Quote\Model\Quote;
use Magento\Checkout\Model\Session as CheckoutSession;

/**
 * Class Authorization cart for payment
 */
class Authorization
{
    /**
     * @var CartValidator
     */
    private $cartValidator;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * Authorization constructor.
     *
     * @param Validator $cartValidator
     * @param CartRepositoryInterface $cartRepository
     * @param CustomerSession $customerSession
     * @param CustomerFactory $customerFactory
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        CartValidator $cartValidator,
        CartRepositoryInterface $cartRepository,
        CustomerSession $customerSession,
        CustomerFactory $customerFactory,
        CheckoutSession $checkoutSession
    ) {
        $this->cartValidator = $cartValidator;
        $this->cartRepository = $cartRepository;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Load quote by cart Id
     *
     * @param int $cartId
     * @return Quote
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadQuote(int $cartId): Quote
    {
        /** @var Quote $quote */
        $quote = $this->cartRepository->getActive($cartId);
        if ($quote->isMultipleShippingAddresses()) {
            $quote->removeAllAddresses();
        }

        $this->cartValidator->validateQuote($quote);

        return $quote;
    }

    /**
     * Authorize customer by quote model
     *
     * @param Quote $quote
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function authorizeCustomer(Quote $quote): void
    {
        if (!$quote->getCustomerIsGuest()) { // customer is not guest
            $authorizedCustomer = $this->customerSession->getCustomer();
            $quoteCustomer = $quote->getCustomer();

            if (
                !$this->customerSession->isLoggedIn() ||
                $quoteCustomer->getEmail() !== $authorizedCustomer->getEmail()
            ) {
                //authorize customer
                $customer = $this->customerFactory->create()
                    ->setStore($quote->getStore())
                    ->loadByEmail($quote->getCustomer()->getEmail());
                $this->customerSession->setCustomerAsLoggedIn($customer);
            }
        } else {
            if ($this->customerSession->isLoggedIn()) {
                $this->customerSession->logout();
            }
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

        $this->checkoutSession->setAwMacPaymentProcess(true);
    }
}
