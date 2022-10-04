<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Payment\Cart\ValidationRules;

use Magento\Framework\Validation\ValidationResult;
use Magento\Quote\Model\Quote;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Manager;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\InventoryInStorePickupQuote\Model\Quote\ValidationRule\InStorePickupQuoteValidationRule;

/**
 * Extended InStorePickupQuote Validation Rule
 */
class ExtendedInStorePickupQuoteValidationRule extends AbstractQuoteValidationRule
{
    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * ExtendedInStorePickupQuoteValidationRule constructor.
     *
     * @param LoggerInterface $logger
     * @param Manager $moduleManager
     */
    public function __construct(LoggerInterface $logger, Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
        parent::__construct($logger);
    }

    /**
     * Get extended validation rule results
     *
     * @param Quote $quote
     * @return ValidationResult[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getValidationRuleResults(Quote $quote): array
    {
        $result = [];
        if ($this->moduleManager->isInventoryStoryPickupQuoteModuleEnabled()) {
            $validationRule = ObjectManager::getInstance()->get(InStorePickupQuoteValidationRule::class);
            $result = $validationRule->validate($quote);
        }
        return $result;
    }
}
