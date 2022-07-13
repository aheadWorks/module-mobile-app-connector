<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment\Cart\ValidationRules;

use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ValidationRules\QuoteValidationRuleInterface;

/**
 * Class Quote validation custom rules composite
 */
class QuoteValidationComposite implements QuoteValidationRuleInterface
{
    /**
     * @var QuoteValidationRuleInterface[]
     */
    private $validationRules = [];

    /**
     * QuoteValidationComposite constructor.
     *
     * @param array $validationRules
     */
    public function __construct(array $validationRules)
    {
        foreach ($validationRules as $validationRule) {
            if (!($validationRule instanceof QuoteValidationRuleInterface)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Instance of the ValidationRuleInterface is expected, got %s instead.',
                        get_class($validationRule)
                    )
                );
            }
        }
        $this->validationRules = $validationRules;
    }

    /**
     * @inheritdoc
     */
    public function validate(Quote $quote): array
    {
        $aggregateResult = [];

        foreach ($this->validationRules as $validationRule) {
            $ruleValidationResult = $validationRule->validate($quote);
            foreach ($ruleValidationResult as $item) {
                if (!$item->isValid()) {
                    array_push($aggregateResult, $item);
                }
            }
        }

        return $aggregateResult;
    }
}
