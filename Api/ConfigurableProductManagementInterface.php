<?php

namespace Aheadworks\MobileAppConnector\Api;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * ConfigurableProductManagementInterface
 * @api
 */
interface ConfigurableProductManagementInterface
{
    /**
     * Get all children for Configurable product with options
     *
     * @param string $sku
     * @return mixed
     * @throws NoSuchEntityException
     * @throws InputException
     */
    public function getChildren(string $sku);
}
