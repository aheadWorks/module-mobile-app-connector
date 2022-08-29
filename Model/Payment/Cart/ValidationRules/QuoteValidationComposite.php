<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment\Cart\ValidationRules;

use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Manager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ValidationRules\QuoteValidationRuleInterface;
use Magento\Framework\App\ObjectManager;
use Magento\InventoryInStorePickupQuote\Model\Quote\ValidationRule\InStorePickupQuoteValidationRule;
use Psr\Log\LoggerInterface;

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
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * QuoteValidationComposite constructor.
     *
     * @param Manager $moduleManager
     * @param LoggerInterface $logger
     * @param array $validationRules
     */
    public function __construct(Manager $moduleManager, LoggerInterface $logger, array $validationRules)
    {
        $this->moduleManager = $moduleManager;
        $this->logger = $logger;
        $this->validationRules = $validationRules;
    }

    /**
     * @inheritdoc
     */
    public function validate(Quote $quote): array
    {
        $aggregateResult = [];

        $this->addMSIValidationRules();
        foreach ($this->validationRules as $validationRule) {
            if (!($validationRule instanceof QuoteValidationRuleInterface)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Quote validation failed: ' .
                        'Instance of the ValidationRuleInterface is expected, got %s instead.',
                        get_class($validationRule)
                    )
                );
            }
            $ruleValidationResult = $validationRule->validate($quote);
            foreach ($ruleValidationResult as $item) {
                if (!$item->isValid()) {
                    array_push($aggregateResult, $item);
                }
            }
        }

        return $aggregateResult;
    }

    /**
     * Add Multi Source Inventory rules
     *
     * @return void
     */
    private function addMSIValidationRules(): void
    {
        if ($this->moduleManager->isIISPQModuleEnabled()) {
            try {
                $this->validationRules['InStorePickupQuoteValidationRule'] =
                    ObjectManager::getInstance()->get(InStorePickupQuoteValidationRule::class);
            } catch (LocalizedException $ex) {
                $this->logger->error(__('MobileAppConnector Payment Exception: "%1"', $ex->getMessage()));
                return;
            }
        }
    }
}
