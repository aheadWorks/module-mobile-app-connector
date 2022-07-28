<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Catalog\Api\Data\CategoryTreeInterface;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class service CategoryTree
 */
class CategoryTree
{
    /**
     * @var CategoryCollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * CategoryTree constructor.
     *
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param ProductCollectionFactory $productCollectionFactory
     */
    public function __construct(
        CategoryCollectionFactory $categoryCollectionFactory,
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Add to the category tree the count of products,
     * available and visible for specific store view id
     *
     * @param CategoryTreeInterface $treeCategories
     * @param int $storeId
     * @return void
     * @throws LocalizedException
     */
    public function setStorefrontProductCount(
        CategoryTreeInterface $treeCategories,
        int $storeId
    ): void
    {
        $categoriesId = $this->extractCategoriesId($treeCategories);
        /** @var CategoryCollection $categoryCollection */
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection
            ->addFieldToFilter('entity_id', ['in' => $categoriesId])
            ->addAttributeToSelect('is_anchor')
        ;

        $this->addProductCountToCategories(
            $categoryCollection,
            $storeId
        );
        $this->mergeProductCountToTree($treeCategories, $categoryCollection);
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
     * Add to the category collection the count of products,
     * available and visible for specific store view id
     *
     * @param CategoryCollection $categoryCollection
     * @param int $storeId
     * @return void
     */
    private function addProductCountToCategories(
        CategoryCollection $categoryCollection,
        int $storeId
    ): void
    {
        /** @var ProductCollection $productCollection */
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->setStore($storeId);
        $productCollection->addCountToCategories($categoryCollection);
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
