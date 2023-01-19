<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\HomepageRepositoryInterface;

/**
 * Class for homepage repository
 */
class HomepageRepository implements HomepageRepositoryInterface
{
    /**
     * Save homepage
     *
     * @param string $homepage
     * @return bool
     */
    public function save($homepage)
    {
        return $homepage;
    }
}
