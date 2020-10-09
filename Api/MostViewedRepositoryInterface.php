<?php
namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface MostViewedRepositoryInterface
 * @api
 */

interface MostViewedRepositoryInterface
{

    /**
     * Get most viewed products
     *
     * @param int $limit
     * @return mixed
     */
    public function getMostViewedProducts($limit);
}
