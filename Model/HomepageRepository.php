<?php
namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\HomepageRepositoryInterface;

/**
 * Class HomepageRepository
 * @package Aheadworks\MobileAppConnector\Model
 */
class HomepageRepository implements HomepageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save($homepage)
    {
        return $homepage;
    }
}