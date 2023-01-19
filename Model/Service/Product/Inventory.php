<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\InventoryCatalog\Model\GetStockIdForCurrentWebsite;
use Magento\InventorySalesApi\Api\AreProductsSalableInterface;
use Magento\Framework\App\ObjectManager;
use Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface;
use Magento\CatalogInventory\Api\StockConfigurationInterface;
use Magento\Store\Model\StoreManagerInterface;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Manager as ModulesManager;

/**
 * Class Inventory provides universal stock status value of product
 */
class Inventory
{
    /**
     * @var StockRegistryProviderInterface
     */
    private $stockRegistryProvider;

    /**
     * @var StockConfigurationInterface
     */
    private $stockConfiguration;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ModulesManager
     */
    private $modulesManager;

    /**
     * @var GetStockIdForCurrentWebsite|null
     */
    private $getServiceStockIdForCurrentWebsite;

    /**
     * @var AreProductsSalableInterface|null
     */
    private $areServiceProductsSalable;

    /**
     * StockStatusProvider constructor.
     *
     * @param StockRegistryProviderInterface $stockRegistryProvider
     * @param StockConfigurationInterface $stockConfiguration
     * @param StoreManagerInterface $storeManager
     * @param ModulesManager $modulesManager
     */
    public function __construct(
        StockRegistryProviderInterface $stockRegistryProvider,
        StockConfigurationInterface $stockConfiguration,
        StoreManagerInterface $storeManager,
        ModulesManager $modulesManager
    ) {
        $this->stockRegistryProvider = $stockRegistryProvider;
        $this->stockConfiguration = $stockConfiguration;
        $this->storeManager = $storeManager;
        $this->modulesManager = $modulesManager;
    }

    /**
     * Is product in stock
     *
     * @param ProductInterface $product
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function isProductInStock($product): bool
    {
        if ($this->modulesManager->isInventoryGraphQlEnabled()) {
            $result = $this->getMultiSourceInventoryStockStatus($product);
        } else {
            $result = $this->getCatalogInventoryStockStatus($product);
        }
        return $result;
    }

    /**
     * Get catalog inventory stock status
     *
     * @param ProductInterface $product
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getCatalogInventoryStockStatus($product): bool
    {
        $websiteId = $this->storeManager->getWebsite()->getId();
        $stockItem = $this->stockRegistryProvider->getStockItem($product->getId(), $websiteId);
        $status = $stockItem->getIsInStock();
        if ($status === null) {
            $stockItem = $this->stockRegistryProvider->getStockItem(
                $product->getId(),
                $this->stockConfiguration->getDefaultScopeId()
            );
            $status = $stockItem->getIsInStock();
        }
        return (bool)$status;
    }

    /**
     * Get multi source inventory stock status
     *
     * @param ProductInterface $product
     * @return bool
     */
    private function getMultiSourceInventoryStockStatus($product): bool
    {
        $stockId = $this->getMultiSourceInventoryStockIdForCurrentWebsite()->execute();
        $result = $this->areMultiSourceInventoryProductsSalable()->execute([$product->getSku()], $stockId);
        $result = current($result);

        return $result->isSalable();
    }

    /**
     * Get object to get multi source inventory stock id for current website
     *
     * @return GetStockIdForCurrentWebsite
     */
    private function getMultiSourceInventoryStockIdForCurrentWebsite(): GetStockIdForCurrentWebsite
    {
        if (!$this->getServiceStockIdForCurrentWebsite) {
            $this->getServiceStockIdForCurrentWebsite =
                ObjectManager::getInstance()->get(GetStockIdForCurrentWebsite::class);
        }
        return $this->getServiceStockIdForCurrentWebsite;
    }

    /**
     * Get object of multi source inventory products salable
     *
     * @return AreProductsSalableInterface
     */
    private function areMultiSourceInventoryProductsSalable(): AreProductsSalableInterface
    {
        if (!$this->areServiceProductsSalable) {
            $this->areServiceProductsSalable = ObjectManager::getInstance()->get(AreProductsSalableInterface::class);
        }
        return $this->areServiceProductsSalable;
    }
}
