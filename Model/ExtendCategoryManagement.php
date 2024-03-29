<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\ExtendCategoryManagementInterface;
use Magento\Catalog\Api\Data\CategoryTreeInterface;
use Magento\Catalog\Model\CategoryManagement;
use Aheadworks\MobileAppConnector\Model\Service\CategoryTree;

/**
 * Class for extend category management
 */
class ExtendCategoryManagement implements ExtendCategoryManagementInterface
{
    /**
     * @var CategoryManagement
     */
    private CategoryManagement $categoryManagement;

    /**
     * @var CategoryTree
     */
    private CategoryTree $categoryTreeService;

    /**
     * ExtendCategoryManagement constructor.
     *
     * @param CategoryManagement $categoryManagement
     * @param CategoryTree $categoryTreeService
     */
    public function __construct(
        CategoryManagement $categoryManagement,
        CategoryTree $categoryTreeService
    ) {
        $this->categoryManagement = $categoryManagement;
        $this->categoryTreeService = $categoryTreeService;
    }

    /**
     * Get tree.
     *
     * @param int $storeId
     * @param int $rootCategoryId
     * @param int $depth
     * @return string
     */
    public function getTree(
        int $storeId,
        int $rootCategoryId = null,
        int $depth = null
    ): CategoryTreeInterface {
        $treeCategories = $this->categoryManagement->getTree($rootCategoryId, $depth);
        $this->categoryTreeService->setStorefrontProductCount(
            $treeCategories,
            $storeId
        );

        return $treeCategories;
    }
}
