<?php
namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule\AheadworksBuildify\Entity\Adapter;

use Aheadworks\Buildify\Model\Buildify\Entity\Adapter\EntityAdapterInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;

/**
 * Class home page for entity field
 *
 */
class Homepage implements EntityAdapterInterface
{
    /**
     * Get entity field
     *
     * @param string $entity
     * @return string
     */
    public function getEntityField($entity)
    {
        $entityFields = $entity->getExtensionAttributes()->getAwEntityFields();

        return isset($entityFields[HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT])
            ? $entityFields[HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT]
            : null;
    }

    /**
     * Update entity field
     *
     * @param string $entity
     * @param string $newEntity
     * @return string
     */
    public function updateEntityField($entity, $newEntity)
    {
        return $entity;
    }

    /**
     * Set html
     *
     * @param string $entity
     * @param string $html
     * @return string
     */
    public function setHtml($entity, $html)
    {
        return $entity;
    }

    /**
     * Get html
     *
     * @param string $entity
     * @return string
     */
    public function getHtml($entity)
    {
        $entity->getContent();
    }

    /**
     * Get id
     *
     * @param string $entity
     * @return string
     */
    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * Get entity type
     *
     * @return string
     */
    public function getEntityType()
    {
        return HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT;
    }

    /**
     * Get custom theme
     *
     * @param string $entity
     * @return string
     */
    public function getCustomTheme($entity)
    {
        return null;
    }
}
