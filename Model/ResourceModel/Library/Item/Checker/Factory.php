<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Checker;

use Aheadworks\DigitalMedia\Model\Downloadable\Link\Purchased\Item\Checker;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class Factory
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Checker
 */
class Factory
{

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    private $objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        $instanceName = Checker::class,
        ResourceConnection $resourceConnection
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param $item
     * @param array $data
     * @return bool
     */
    public function create(
        $item,
        array $data = []
    ) {
        $collection = $this->objectManager->create($this->instanceName, $data);
        return $collection->isLibraryItem($item);
    }
}
