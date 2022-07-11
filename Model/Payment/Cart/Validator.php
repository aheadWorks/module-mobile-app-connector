<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment\Cart;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\Error;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ValidationRules\QuoteValidationRuleInterface;

/**
 * Class Validator of cart for payment
 */
class Validator
{
    /**
     * @var QuoteValidationRuleInterface[]
     */
    private $quoteValidationRules;

    /**
     * Validator constructor.
     *
     * @param QuoteValidationRuleInterface[] $quoteValidationRules
     */
    public function __construct(array $quoteValidationRules)
    {
        $this->quoteValidationRules = $quoteValidationRules;
    }

    /**
     * Validates quote
     *
     * @param Quote $quote
     * @return $this
     * @throws LocalizedException
     */
    public function validateQuote(Quote $quote): Validator
    {
        if ($quote->getHasError()) {
            $errors = $this->getQuoteErrors($quote);
            throw new LocalizedException(__($errors ?: 'Something went wrong. Please try to place the order again.'));
        }

        foreach ($this->validateQuoteByRules($quote) as $validationResult) {
            if ($validationResult->isValid()) {
                continue;
            }

            $messages = $validationResult->getErrors();
            $defaultMessage = array_shift($messages);
            if ($defaultMessage && !empty($messages)) {
                $defaultMessage .= ' %1';
            }

            if ($defaultMessage) {
                throw new LocalizedException(__($defaultMessage, implode(' ', $messages)));
            }
        }

        return $this;
    }

    /**
     * Validate quote by rules
     *
     * @param Quote $quote
     * @return array
     */
    private function validateQuoteByRules(Quote $quote): array
    {
        $aggregateResult = [];
        foreach ($this->quoteValidationRules as $quoteValidationRule) {
            if ($quoteValidationRule instanceof QuoteValidationRuleInterface) {
                $ruleValidationResult = $quoteValidationRule->validate($quote);
                foreach ($ruleValidationResult as $item) {
                    if (!$item->isValid()) {
                        $aggregateResult[] = $item;
                    }
                }
            }
        }

        return $aggregateResult;
    }

    /**
     * Parses quote error messages and concatenates them into single string
     *
     * @param Quote $quote
     * @return string
     */
    private function getQuoteErrors(Quote $quote): string
    {
        $errors = array_map(
            function (Error $error) {
                return $error->getText();
            },
            $quote->getErrors()
        );

        return implode(PHP_EOL, $errors);
    }
}
