<?php

namespace Aheadworks\MobileAppConnector\Api;

use Exception;

/**
 * Interface MostViewedProductInterface
 * @api
 */
interface MostViewedProductInterface
{
    /**
     * Get most viewed products
     *
     * @param int $limit
     * @param int|null $storeId
     * @return bool|mixed
     * @throws Exception
     */
    public function getMostViewedProducts($limit, $storeId = null);
}
