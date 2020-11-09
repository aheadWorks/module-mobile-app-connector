<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;
use Exception;
/**
 * AppOverViewRepositoryInterface
 * @api
 */
interface AppOverViewRepositoryInterface
{

    /**
     * get app overview.
     * @return null|string
     * @throws Exception
     */
    public function getAppTenantId();
}
