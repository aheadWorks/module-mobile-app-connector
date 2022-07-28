<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Block\Widget\Product;

use Aheadworks\MobileAppConnector\Model\Product\Resolver as ProductResolver;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\CatalogWidget\Model\Rule;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\Rule\Model\Condition\Sql\Builder as SqlBuilder;
use Magento\Widget\Helper\Conditions;
use Aheadworks\MobileAppConnector\Api\BestSellingProductInterfaceFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Aheadworks\MobileAppConnector\ViewModel\Widget\Config as ConfigViewModel;

/**
 * Class BestSellingProducts Widget
 */
class BestSellingProducts extends ProductsList
{
    /**
     * @var BestSellingProductInterfaceFactory
     */
    protected $bestSellingProductFactory;

    /**
     * BestSellingProducts constructor.
     *
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Visibility $catalogProductVisibility
     * @param HttpContext $httpContext
     * @param SqlBuilder $sqlBuilder
     * @param Rule $rule
     * @param Conditions $conditionsHelper
     * @param BestSellingProductInterfaceFactory $bestSellingProductFactory
     * @param ConfigViewModel $configViewModel
     * @param array $data
     * @param Json|null $json
     * @param LayoutFactory|null $layoutFactory
     * @param EncoderInterface|null $urlEncoder
     * @param CategoryRepositoryInterface|null $categoryRepository
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        HttpContext $httpContext,
        SqlBuilder $sqlBuilder,
        Rule $rule,
        Conditions $conditionsHelper,
        BestSellingProductInterfaceFactory $bestSellingProductFactory,
        ConfigViewModel $configViewModel,
        array $data = [],
        Json $json = null,
        LayoutFactory $layoutFactory = null,
        EncoderInterface $urlEncoder = null,
        CategoryRepositoryInterface $categoryRepository = null
    ) {
        $this->bestSellingProductFactory = $bestSellingProductFactory;
        $data['view_model'] = $configViewModel;
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $conditionsHelper,
            $data,
            $json,
            $layoutFactory,
            $urlEncoder,
            $categoryRepository
        );
    }

    /**
     * @inheritDoc
     */
    public function createCollection(): Collection
    {
        $bestSellingProduct = $this->bestSellingProductFactory->create();

        $products = $bestSellingProduct->getBestSellingProducts(
            $this->getData('period_type'),
            $this->getData('store_id') ?: $this->_storeManager->getStore()->getId()
        );
        $productsIds = array_column($products, ProductResolver::ID);

        $collection = $this->productCollectionFactory->create();
        if ($this->getData('store_id') !== null) {
            $collection->setStoreId($this->getData('store_id'));
        }

        $collection->addFieldToFilter('entity_id', ['in' => $productsIds])
            ->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        /**
         * Change sorting attribute to entity_id because created_at can be the same for products fastly created
         * one by one and sorting by created_at is indeterministic in this case.
         */
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addStoreFilter();

        $conditions = $this->getConditions();
        $conditions->collectValidatedAttributes($collection);
        $this->sqlBuilder->attachConditionToCollection($collection, $conditions);

        /**
         * Prevent retrieval of duplicate records. This may occur when multiselect product attribute matches
         * several allowed values from condition simultaneously
         */
        $collection->distinct(true);

        if (empty($this->getData('sku_products'))) {
            $this->setData('sku_products', $collection->getColumnValues('sku'));
            $collection->clear();
        }

        $collection->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1));
        return $collection;
    }
}
