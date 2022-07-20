<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Catalog\Api\Data\CategoryTreeInterface;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

/**
 * Class service CategoryTree
 */
class CategoryTree
{
    /**
     * @var CategoryCollectionFactory
     */
    private $categoriesCollectionFactory;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * CategoryTree constructor.
     *
     * @param CategoryCollectionFactory $categoriesCollectionFactory
     * @param ProductCollectionFactory $productCollectionFactory
     */
    public function __construct(
        CategoryCollectionFactory $categoriesCollectionFactory,
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->categoriesCollectionFactory = $categoriesCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Set storefront product count to tree of categories
     *
     * @param CategoryTreeInterface $treeCategories
     * @return void
     */
    public function setStorefrontProductCount(CategoryTreeInterface $treeCategories): void
    {
        $categoriesId = $this->extractCategoriesId($treeCategories);
        $categoryCollection = $this->categoriesCollectionFactory->create()
            ->addFieldToFilter('entity_id', ['in' => $categoriesId]);

        $this->addProductCountToCategories($categoryCollection);
        $this->mergeProductCountToTree($treeCategories, $categoryCollection);

        $this->calcTotalProductCountTree($treeCategories);
    }

    /**
     * Extract category id list from tree of categories
     *
     * @param CategoryTreeInterface $node
     * @return array
     */
    private function extractCategoriesId(CategoryTreeInterface $node): array
    {
        $categoriesId = [];
        if ($node->getId()) {
            $categoriesId[] = $node->getId();
            if ($childrenNode = $node->getChildrenData()) {
                foreach ($childrenNode as $childNode) {
                    $nodeCategoriesId = $this->extractCategoriesId($childNode);
                    foreach ($nodeCategoriesId as $nodeCategoryId) {
                        $categoriesId[] = $nodeCategoryId;
                    }
                }
            }
        }
        return $categoriesId;
    }

    /**
     * Add storefront product count to categories collection
     *
     * @param CategoryCollection $categoryCollection
     * @return void
     */
    private function addProductCountToCategories(CategoryCollection $categoryCollection): void
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addCountToCategories($categoryCollection);
    }

    /**
     * Calc total product count for categories of tree
     *
     * @param array|CategoryTreeInterface $treeCategories
     * @return void
     */
    private function calcTotalProductCountTree($treeCategories): void
    {
        $treeCategories = is_array($treeCategories) ? $treeCategories : [$treeCategories];
        /** @var CategoryTreeInterface $treeCategory */
        foreach ($treeCategories as $treeCategory) {
            $productCountSum = $treeCategory->getProductCount() + $this->getChildrenTotalProductCount($treeCategory);
            $treeCategory->setProductCount($productCountSum);
            if ($treeCategory->getChildrenData()) {
                $this->calcTotalProductCountTree($treeCategory->getChildrenData());
            }
        }
    }

    /**
     * Get total product count of category tree children
     *
     * @param CategoryTreeInterface $node
     * @return int
     */
    private function getChildrenTotalProductCount(CategoryTreeInterface $node): int
    {
        $sum = 0;
        foreach ($node->getChildrenData() as $child) {
            $sum += $child->getProductCount() + $this->getChildrenTotalProductCount($child);
        }
        return $sum;
    }

    /**
     * Merge product count of categories to product count of tree categories
     *
     * @param array|CategoryTreeInterface $treeCategories
     * @param CategoryCollection $categoryCollection
     * @return void
     */
    private function mergeProductCountToTree($treeCategories, CategoryCollection $categoryCollection): void
    {
        $treeCategories = is_array($treeCategories) ? $treeCategories : [$treeCategories];
        /** @var CategoryTreeInterface $treeCategory */
        foreach ($treeCategories as $treeCategory) {
            if ($collectionItem = $categoryCollection->getItemById($treeCategory->getId())) {
                $treeCategory->setProductCount($collectionItem->getProductCount());
            }
            if ($treeCategory->getChildrenData()) {
                $this->mergeProductCountToTree($treeCategory->getChildrenData(), $categoryCollection);
            }
        }
    }
}
