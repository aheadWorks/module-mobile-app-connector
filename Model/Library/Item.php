<?php
namespace Aheadworks\MobileAppConnector\Model\Library;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Downloadable\Model\ResourceModel\Link\Purchased\Item as  ItemResource;

/**
 * Class Item for set and get items
 *
 */
class Item extends AbstractModel implements LibraryItemInterface
{
    /**
     * Item construct
     */
    protected function _construct()
    {
        $this->_init(ItemResource::class);
    }

    /**
     * Get item id
     *
     * @return string
     */
    public function getItemId()
    {
        return $this->getData(self::ITEM_ID);
    }

    /**
     * Set item id
     *
     * @param string $itemId
     * @return bool
     */
    public function setItemId($itemId)
    {
        return $this->setData(self::ITEM_ID, $itemId);
    }

    /**
     * Get order item id
     *
     * @return string
     */
    public function getOrderItemId()
    {
        return $this->getData(self::ORDER_ITEM_ID);
    }

    /**
     * Set order item id
     *
     * @param string $orderItemId
     * @return bool
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * Get product name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * Set product name
     *
     * @param string $productName
     * @return bool
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * Get product image url
     *
     * @return string
     */
    public function getProductImageUrl()
    {
        return $this->getData(self::PRODUCT_IMAGE_URL);
    }

    /**
     * Set product image url
     *
     * @param string $productImageUrl
     * @return bool
     */
    public function setProductImageUrl($productImageUrl)
    {
        return $this->setData(self::PRODUCT_IMAGE_URL, $productImageUrl);
    }

    /**
     * Get link title
     *
     * @return string
     */
    public function getLinkTitle()
    {
        return $this->getData(self::LINK_TITLE);
    }

    /**
     * Set link title
     *
     * @param string $linkTitle
     * @return bool
     */
    public function setLinkTitle($linkTitle)
    {
        return $this->setData(self::LINK_TITLE, $linkTitle);
    }

    /**
     * Get link hash
     *
     * @return string
     */
    public function getLinkHash()
    {
        return $this->getData(self::LINK_HASH);
    }

    /**
     * Set link hash
     *
     * @param string $linkHash
     * @return bool
     */
    public function setLinkHash($linkHash)
    {
        return $this->setData(self::LINK_HASH, $linkHash);
    }

    /**
     * Get download url
     *
     * @return string
     */
    public function getDownloadUrl()
    {
        return $this->getData(self::DOWNLOAD_URL);
    }

    /**
     * Set download url
     *
     * @param string $downloadUrl
     * @return bool
     */
    public function setDownloadUrl($downloadUrl)
    {
        return $this->setData(self::DOWNLOAD_URL, $downloadUrl);
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set type
     *
     * @param string $type
     * @return bool
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get remaining downloads
     *
     * @return string
     */
    public function getRemainingDownloads()
    {
        return $this->getData(self::REMAINING_DOWNLOADS);
    }

    /**
     * Set remaining downloads
     *
     * @param string $remainingDownloads
     * @return bool
     */
    public function setRemainingDownloads($remainingDownloads)
    {
        return $this->setData(self::REMAINING_DOWNLOADS, $remainingDownloads);
    }

    /**
     * Get is downloadable
     *
     * @return string
     */
    public function getIsDownloadable()
    {
        return $this->getData(self::IS_DOWNLOADABLE);
    }

    /**
     * Set is downloadable
     *
     * @param string $isDownloadble
     * @return bool
     */
    public function setIsDownloadable($isDownloadble)
    {
        return $this->setData(self::IS_DOWNLOADABLE, $isDownloadble);
    }

    /**
     * Get extension attributes
     *
     * @return string
     */
    public function getExtensionAttributes()
    {
        return $this->getData(self::EXTENSION_ATTRIBUTES_KEY);
    }

    /**
     * Set is extension attributes
     *
     * @param string $extensionAttributes
     * @return bool
     */
    public function setExtensionAttributes(
        \Aheadworks\MobileAppConnector\Api\Data\LibraryItemExtensionInterface $extensionAttributes
    ) {
        return $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);
    }
}
