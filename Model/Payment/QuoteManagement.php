<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment;

use Magento\Quote\Model\QuoteValidator as CartValidator;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;

/**
 * Class QuoteManagement to manage quote
 */
class QuoteManagement
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
     * QuoteManagement constructor.
     *
     * @param CartValidator $cartValidator
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        CartValidator $cartValidator,
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartValidator = $cartValidator;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Loading quote by cartId
     *
     * @param int $cartId
     * @return Quote
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadQuoteByCartId(int $cartId): Quote
    {
        return $this->cartRepository->getActive($cartId);
    }

    /**
     * Validate quote for payment
     *
     * @param Quote $quote
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function validateQuote(Quote $quote): void
    {
        if ($quote->isMultipleShippingAddresses()) {
            $quote->removeAllAddresses();
        }

        $this->cartValidator->validateBeforeSubmit($quote);
    }
}
