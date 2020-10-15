<?php
namespace Aheadworks\MobileAppConnector\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface LibraryItemInterface
 *
 * @package Aheadworks\MobileAppConnector\Api\Data
 */
interface LibraryItemInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of the data array.
     * Identical to the name of the getter in snake case
     */
    const ITEM_ID = 'item_id';
    const ORDER_ITEM_ID = 'order_item_id';
    const PRODUCT_NAME = 'product_name';
    const PRODUCT_IMAGE_URL = 'product_image_url';
    const LINK_TITLE = 'link_title';
    const LINK_HASH = 'link_hash';
    const DOWNLOAD_URL = 'download_url';
    /**#@-*/

    /**
     * Get item id
     *
     * @return int
     */
    public function getItemId();

    /**
     * Set item id
     *
     * @param int $itemId
     * @return $this
     */
    public function setItemId($itemId);

    /**
     * Get order item id
     *
     * @return int
     */
    public function getOrderItemId();

    /**
     * Set order item id
     *
     * @param int $orderItemId
     * @return $this
     */
    public function setOrderItemId($orderItemId);

    /**
     * Get product name
     *
     * @return string
     */
    public function getProductName();

    /**
     * Set product name
     *
     * @param string $productName
     * @return $this
     */
    public function setProductName($productName);

    /**
     * Get product image url
     *
     * @return string
     */
    public function getProductImageUrl();

    /**
     * Set product image url
     *
     * @param string $productImageUrl
     * @return $this
     */
    public function setProductImageUrl($productImageUrl);

    /**
     * Get link title
     *
     * @return string
     */
    public function getLinkTitle();

    /**
     * Set link title
     *
     * @param string $linkTitle
     * @return $this
     */
    public function setLinkTitle($linkTitle);

    /**
     * Get link hash
     *
     * @return string
     */
    public function getLinkHash();

    /**
     * Set link hash
     *
     * @param string $linkHash
     * @return $this
     */
    public function setLinkHash($linkHash);

    /**
     * Get download url
     *
     * @return string
     */
    public function getDownloadUrl();

    /**
     * Set download url
     *
     * @param string $downloadUrl
     * @return $this
     */
    public function setDownloadUrl($downloadUrl);

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Aheadworks\MobileAppConnector\Api\Data\LibraryItemExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object
     *
     * @param \Aheadworks\MobileAppConnector\Api\Data\LibraryItemExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Aheadworks\MobileAppConnector\Api\Data\LibraryItemExtensionInterface $extensionAttributes
    );
}
