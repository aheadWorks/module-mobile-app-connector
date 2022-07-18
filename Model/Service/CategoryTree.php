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
        $categoriesCollection = $this->categoriesCollectionFactory->create()
            ->addFieldToFilter('entity_id', ['in' => $categoriesId]);

        $this->addProductCountToCategories($categoriesCollection);
        $this->mergeProductCountToTree($treeCategories, $categoriesCollection);
    }

    /**
     * Extract categories id from tree of categories
     *
     * @param array|CategoryTreeInterface $treeCategories
     * @param array $categoriesId
     * @return array
     */
    private function extractCategoriesId($treeCategories, array $categoriesId = []): array
    {
        $treeCategories = is_array($treeCategories) ? $treeCategories : [$treeCategories];
        foreach ($treeCategories as $treeCategory) {
            $categoriesId[] = $treeCategory->getId();
            if ($treeCategory->getChildrenData()) {
                $childrenCategoriesId = $this->extractCategoriesId($treeCategory->getChildrenData(), $categoriesId);
                foreach ($childrenCategoriesId as $childCategoriesId) {
                    $categoriesId[] = $childCategoriesId;
                }
            }
        }
        return array_unique($categoriesId);
    }

    /**
     * Add storefront product count to categories collection
     *
     * @param CategoryCollection $categories
     * @return void
     */
    private function addProductCountToCategories(CategoryCollection $categories): void
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addCountToCategories($categories);
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
