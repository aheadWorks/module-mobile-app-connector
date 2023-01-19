<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;

use Exception;

/**
 * Interface AppOverViewRepositoryInterface
 * @api
 */
interface AppOverViewRepositoryInterface
{
    /**
     * Get app overview.
     *
     * @return null|string
     * @throws Exception
     */
    public function getAppTenantId();
}
