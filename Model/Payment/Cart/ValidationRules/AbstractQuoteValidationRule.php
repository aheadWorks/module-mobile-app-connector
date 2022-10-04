<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment\Cart\ValidationRules;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationResult;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ValidationRules\QuoteValidationRuleInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Abstract Quote Validation Rule - allows to extend validation rule
 */
abstract class AbstractQuoteValidationRule implements QuoteValidationRuleInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * AbstractQuoteValidationRule constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Validate Quote model.
     *
     * @param Quote $quote
     * @return ValidationResult[]
     */
    public function validate(Quote $quote): array
    {
        try {
            return $this->getValidationRuleResults($quote);
        } catch (LocalizedException $ex) {
            $this->logger->error(__('MobileAppConnector Payment Exception: "%1"', $ex->getMessage()));
            return [];
        }
    }

    /**
     * Get extended validation rule results
     *
     * @param Quote $quote
     * @return ValidationResult[]
     */
    abstract protected function getValidationRuleResults(Quote $quote): array;
}
