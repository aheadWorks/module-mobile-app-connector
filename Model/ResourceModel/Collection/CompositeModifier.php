<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Collection;

use Magento\Framework\Exception\ConfigurationMismatchException;

/**
 * Class CompositeModifier
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Collection
 */
class CompositeModifier implements ModifierInterface
{
    /**
     * @var ModifierInterface[]
     */
    private $modifiers;

    /**
     * @param ModifierInterface[] $modifiers
     */
    public function __construct(array $modifiers = [])
    {
        $this->modifiers = $modifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData($item)
    {
        foreach ($this->modifiers as $modifier) {
            if (!$modifier instanceof ModifierInterface) {
                throw new ConfigurationMismatchException(
                    __('Collection item modifier must implement %1', ModifierInterface::class)
                );
            }
            $item = $modifier->modifyData($item);
        }
        return $item;
    }
}
