<?php
/**
 * A Magento 2 module named Aheadworks\MobileAppConnector
 *
 */
namespace Aheadworks\MobileAppConnector\Api;

use Aheadworks\MobileAppConnector\Api\Data\OverViewInterface;

/**
 * OverViewRepositoryInterface
 * @api
 */
interface OverViewRepositoryInterface
{

    /**
     * Loads a overview tenant.
     *
     * @return \Aheadworks\MobileAppConnector\Model\OverView\OverViewManagement.
     */
    public function getTenantId();
}
