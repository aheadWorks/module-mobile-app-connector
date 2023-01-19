<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Magento\Framework\Model\AbstractModel;
use Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface;

/**
 * Class for Home page
 */
class Homepage extends AbstractModel implements HomepageInterface
{
    /**
     * Homepage constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId(self::HOME_PAGE_BUILDIFY_ID);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData(self::ID, $id);

        return $this;
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->setData(self::CONTENT, $content);

        return $this;
    }

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->getData(self::EXTENSION_ATTRIBUTES_KEY);
    }

    /**
     * Set an extension attributes object
     *
     * @param \Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(HomepageExtensionInterface $extensionAttributes)
    {
        $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);

        return $this;
    }
}
