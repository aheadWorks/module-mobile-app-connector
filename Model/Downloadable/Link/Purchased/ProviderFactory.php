<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class ProviderFactory
 * @package  Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased
 */
class ProviderFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create subscription details config provider instance
     *
     * @param string $className
     * @return object
     */
    public function create($className)
    {
        $instance = $this->objectManager->create($className);
        return $instance;
    }
}