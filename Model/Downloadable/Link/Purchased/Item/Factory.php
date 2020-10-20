<?php

namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item;

use Aheadworks\DigitalMedia\Model\Downloadable\Link\Purchased\Item\Checker as DigitalMediaChecker;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Manager as ModuleManager;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class Factory
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item
 */
class Factory
{

    /**
     * @var moduleManager
     */
    private $moduleManager;

    /**
     * @var objectManager
     */
    protected $objectManager;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * @param ModuleManager $moduleManager
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        ModuleManager $moduleManager,
        ObjectManagerInterface $objectManager,
        $instanceName = DigitalMediaChecker::class
    ) {
        $this->moduleManager = $moduleManager;
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    /**
     * @param array $data
     * @return false|mixed
     */
    public function create($data = [])
    {
        if ($this->moduleManager->isDMModuleEnabled()) {
            return $this->objectManager->create($this->instanceName, $data);
        }
        return false;
    }
}
