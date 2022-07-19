<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Api;

use Magento\Catalog\Api\Data\CategoryTreeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface ExtendCategoryManagementInterface
 * @api
 */
interface ExtendCategoryManagementInterface
{
    /**
     * Getting extended categories that include the count of storefront products
     *
     * @param int|null $rootCategoryId
     * @param int|null $depth
     * @return CategoryTreeInterface containing Tree objects
     * @throws NoSuchEntityException If ID is not found
     */
    public function getTree(?int $rootCategoryId = null, ?int $depth = null): CategoryTreeInterface;
}
