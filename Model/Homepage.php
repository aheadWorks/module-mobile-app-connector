<?php

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Magento\Framework\Model\AbstractModel;
use Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionInterface;

/**
 * Class Homepage
 * @package Aheadworks\MobileAppConnector\Model
 */
class Homepage extends AbstractModel implements HomepageInterface
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId(self::HOME_PAGE_BUILDIFY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->setData(self::ID, $id);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->setData(self::CONTENT, $content);

        return $this;
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
    public function setExtensionAttributes(HomepageExtensionInterface $extensionAttributes)
    {
        $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);

        return $this;
    }
}