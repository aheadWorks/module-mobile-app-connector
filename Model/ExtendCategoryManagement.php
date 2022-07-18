<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\ExtendCategoryManagementInterface;
use Magento\Catalog\Api\Data\CategoryTreeInterface;
use Magento\Catalog\Model\CategoryManagement;
use Aheadworks\MobileAppConnector\Model\Service\CategoryTree;

/**
 * Class ExtendCategoryManagement
 */
class ExtendCategoryManagement implements ExtendCategoryManagementInterface
{
    /**
     * @var CategoryManagement
     */
    private $categoryManagement;

    /**
     * @var CategoryTree
     */
    private $categoryTreeService;

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
     * @inheritDoc
     */
    public function getTree(int $rootCategoryId = null, int $depth = null): CategoryTreeInterface
    {
        $treeCategories = $this->categoryManagement->getTree($rootCategoryId, $depth);
        $this->categoryTreeService->setStorefrontProductCount($treeCategories);

        return $treeCategories;
    }
}
