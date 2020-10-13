<?php
namespace Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Downloadable\Model\Link\Purchased as PurchasedLink;
use Magento\Downloadable\Model\Link\PurchasedFactory as PurchasedLinkFactory;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\Collection as PurchasedLinkCollection;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\CollectionFactory as PurchasedLinkCollectionFactory;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Provider
 *
 * @package Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased
 */
class Provider
{
    /**
     * @var PurchasedLinkCollectionFactory
     */
    private $purchasedLinkCollectionFactory;

    /**
     * @var PurchasedLinkFactory
     */
    private $purchasedLinkFactory;

    /**
    * @var UrlInterface
    */
    private $urlBuilder;

    /**
     * @var Image
     */
    private $imageHelper;

    /**
     * @var Emulation
     */
    protected $appEmulation;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @param PurchasedLinkCollectionFactory $purchasedLinkCollectionFactory
     * @param PurchasedLinkFactory $purchasedLinkFactory
     * @param UrlInterface $urlBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param Image $imageHelper
     * @param Emulation $appEmulation
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        PurchasedLinkCollectionFactory $purchasedLinkCollectionFactory,
        PurchasedLinkFactory $purchasedLinkFactory,
        UrlInterface $urlBuilder,
        ProductRepositoryInterface $productRepository,
        Image $imageHelper,
        Emulation $appEmulation,
        StoreManagerInterface $storeManager
    ) {
        $this->purchasedLinkCollectionFactory = $purchasedLinkCollectionFactory;
        $this->purchasedLinkFactory = $purchasedLinkFactory;
        $this->urlBuilder   = $urlBuilder;
        $this->productRepository = $productRepository;
        $this->appEmulation = $appEmulation;
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
    }

    /**
     * Retrieve array of purchased links ids for specific customer
     *
     * @param int $customerId
     * @return array
     */
    public function getIds(int $customerId)
    {
        /** @var PurchasedLinkCollection $collection */
        $collection = $this->purchasedLinkCollectionFactory->create();
        $collection
            ->addFieldToFilter('customer_id', $customerId)
            ->addOrder('created_at', PurchasedLinkCollection::SORT_ORDER_DESC);
        $ids = [];
        /** @var PurchasedLink $item */
        foreach ($collection->getItems() as $item) {
            $ids[] = $item->getId();
        }
        return $ids;
    }

    /**
     * Retrieve purchased link by id
     *
     * @param int $purchasedLinkId
     * @return PurchasedLink
     */
    public function getById(int $purchasedLinkId)
    {
        /** @var PurchasedLink $purchasedLink */
        $purchasedLink = $this->purchasedLinkFactory->create();
        $purchasedLink->load($purchasedLinkId);
        return $purchasedLink;
    }

    /**
     * Retrieve purchased item name purchased by id
     *
     * @param int $orderItemId
     * @return Purchaseditemname
     */
    public function getPurcheseditem(int $orderItemId)
    {
        /** @var PurchasedLink $purchasedLink */
        $collection = $this->purchasedLinkCollectionFactory->create();
        $collection
            ->addFieldToFilter('order_item_id', $orderItemId);

        $productName = [];
        foreach ($collection->getItems() as $item) {
            $productName[] = $item->getProductName();
        }
        return $productName[0];
    }

    /**
     * @param int $productId
     * @return string
     * @throws NoSuchEntityException
     */
    public function getItemImageUrl($productId)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, Area::AREA_FRONTEND, true);
        try {
            $product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return 'product not found';
        }
        return $this->imageHelper->init($product, 'product_thumbnail_image')->getUrl();
    }

    /**
     * @param $linkHash
     * @return string
     */
    public function getItemViewUrl($linkHash)
    {
        return $this->urlBuilder->getUrl(
            'downloadable/download/link',
            ['id' => $linkHash, '_secure' => true]
        );
    }
}
