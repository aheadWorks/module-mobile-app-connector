<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Collection;

use Magento\Framework\DataObject;

/**
 * Interface ModifierInterface
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Collection
 */
interface ModifierInterface
{
    /**
     * Modify data of collection item
     *
     * @param DataObject $item
     * @return DataObject
     */
    public function modifyData($item);
}