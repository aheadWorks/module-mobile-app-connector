<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Plugin\AwBuildify\Model;

use Aheadworks\Buildify\Model\Config as Subject;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;

/**
 * Class ConfigPlugin to mobile app connector setting
 */
class ConfigPlugin
{
    /**
     * Turns on buildify for mobile app connector entity type
     *
     * @param Subject $subject
     * @param callable $proceed
     * @param string $type
     * @param int|null $storeId
     * @return bool
     */
    public function aroundIsEnabledForEntityType(
        Subject $subject,
        callable $proceed,
        string $type,
        int $storeId = null
    ): bool {
        return $type === HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT ?: $proceed($type, $storeId);
    }
}
