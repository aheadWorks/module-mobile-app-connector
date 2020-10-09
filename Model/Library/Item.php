<?php
namespace Aheadworks\MobileAppConnector\Model\Library;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection as LibraryItemCollection;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\UrlInterface;

/**
 * Class Item
 *
 * @package Aheadworks\MobileAppConnector\Model\Library
 * @codeCoverageIgnore
 */
class Item extends AbstractModel implements LibraryItemInterface
{

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(LibraryItemCollection::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemId()
    {
        return $this->getData(self::ITEM_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setItemId($itemId)
    {
        return $this->setData(self::ITEM_ID, $itemId);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderItemId()
    {
        return $this->getData(self::ORDER_ITEM_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductImageUrl()
    {
        if ($this->getData(self::PRODUCT_IMAGE_URL) !='') {
            return $this->urlBuilder->getUrl('media/catalog/product/', ['_secure' =>true]) . $this->getData(self::PRODUCT_IMAGE_URL);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setProductImageUrl($productImageUrl)
    {
        return $this->setData(self::PRODUCT_IMAGE_URL, $productImageUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkTitle()
    {
        return $this->getData(self::LINK_TITLE);
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkTitle($linkTitle)
    {
        return $this->setData(self::LINK_TITLE, $linkTitle);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkFile()
    {
        return $this->getData(self::LINK_FILE);
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkFile($linkFile)
    {
        return $this->setData(self::LINK_FILE, $linkFile);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkHash()
    {
        return $this->getData(self::LINK_HASH);
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkHash($linkHash)
    {
        return $this->setData(self::LINK_HASH, $linkHash);
    }

    /**
     * {@inheritdoc}
     */
    public function getViewUrl()
    {
        return $this->urlBuilder->getUrl(
            'downloadable/download/link',
            ['id' => $this->getData(self::LINK_HASH), '_secure' => true]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setViewUrl($viewUrl)
    {
        return $this->setData(self::VIEW_URL, $viewUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionAttributes()
    {
        return $this->getData(self::EXTENSION_ATTRIBUTES_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        \Aheadworks\MobileAppConnector\Api\Data\LibraryItemExtensionInterface $extensionAttributes
    ) {
        return $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);
    }
}
