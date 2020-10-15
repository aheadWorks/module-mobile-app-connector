<?php
namespace Aheadworks\MobileAppConnector\Model\Library;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\Item as  ItemResource;

/**
 * Class Item
 *
 * @package Aheadworks\MobileAppConnector\Model\Library
 * @codeCoverageIgnore
 */
class Item extends AbstractModel implements LibraryItemInterface
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(ItemResource::class);
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
        return $this->getData(self::PRODUCT_IMAGE_URL);
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
    public function getDownloadUrl()
    {
        return $this->getData(self::DOWNLOAD_URL);
    }

    /**
     * {@inheritdoc}
     */
    public function setDownloadUrl($downloadUrl)
    {
        return $this->setData(self::DOWNLOAD_URL, $downloadUrl);
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
