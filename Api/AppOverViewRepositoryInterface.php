<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;

/**
 * AppOverViewRepositoryInterface
 * @api
 */
interface AppOverViewRepositoryInterface
{

    /**
     * get app overview.
     * @return array.
     */
    public function getTenantId();
}
