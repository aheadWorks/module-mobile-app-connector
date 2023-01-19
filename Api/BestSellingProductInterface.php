<?php

namespace Aheadworks\MobileAppConnector\Api;

use Exception;

/**
 * Interface BestSellingProductInterface
 * @api
 */

interface BestSellingProductInterface
{
    /**
     * Get Best Selling products
     *
     * @param string $period
     * @param int|null $storeId
     * @return bool|mixed
     * @throws Exception
     */
    public function getBestSellingProducts($period, $storeId = null);
}
