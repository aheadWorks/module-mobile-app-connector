<?php
namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule\AheadworksBuildify\Entity\Adapter;

use Aheadworks\Buildify\Model\Buildify\Entity\Adapter\EntityAdapterInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;

/**
 * Class Homepage
 * @package Aheadworks\MobileAppConnector\Model\ThirdParty\Buildify\Entity\ToBuilderConfig\Converter\AwMobConnector
 */
class Homepage implements EntityAdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityField($entity)
    {
        $entityFields = $entity->getExtensionAttributes()->getAwEntityFields();

        return isset($entityFields[HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT])
            ? $entityFields[HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function updateEntityField($entity, $newEntity)
    {
        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function setHtml($entity, $html)
    {
        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml($entity)
    {
        $entity->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityType()
    {
        return HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomTheme($entity)
    {
        return null;
    }
}
