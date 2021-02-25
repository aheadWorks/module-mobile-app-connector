<?php
namespace Aheadworks\MobileAppConnector\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Class HomepageInterface
 * @package Aheadworks\MobileAppConnector\Api\Data
 */
interface HomepageInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of the data array.
     * Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const CONTENT = 'content';
    /**#@-*/
    const AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT = 'aw_mobileappconnector_homepage_content';
    //todo
    const HOME_PAGE_BUILDIFY_ID = 1;

    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object
     *
     * @param \Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface $extensionAttributes
    );
}