<?php
namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface MostViewedProductInterface
 * @api
 */

interface MostViewedProductInterface
{

    /**
     * Get most viewed products
     * @param int $limit
     * @return bool|array
     * @throws Exception
     */
    public function getMostViewedProducts($limit);
}
