<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface ExtendCategoryManagementInterface
 * @api
 */
interface ExtendCategoryManagementInterface
{
    /**
     * Getting extended categories that include the count of products, available and visible for specific store view id
     *
     * @param int $storeId
     * @param int|null $rootCategoryId
     * @param int|null $depth
     * @return \Magento\Catalog\Api\Data\CategoryTreeInterface containing Tree objects
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTree(
        int $storeId,
        ?int $rootCategoryId = null,
        ?int $depth = null
    ): \Magento\Catalog\Api\Data\CategoryTreeInterface;
}
