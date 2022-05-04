<?php
namespace Aheadworks\MobileAppConnector\Model\ExtensionAttributes\Builder;

use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionFactory;

/**
 * Class Homepage
 * @package Aheadworks\MobileAppConnector\Model\ExtensionAttributes\Builder
 */
class Homepage
{
    /**
     * @var HomepageExtensionFactory
     */
    private $homepageExtensionFactory;

    /**
     * @param HomepageExtensionFactory $homepageExtensionFactory
     */
    public function __construct(
        HomepageExtensionFactory $homepageExtensionFactory
    ) {
        $this->homepageExtensionFactory = $homepageExtensionFactory;
    }

    public function setAwEntityContentFieldAttribute($homepage, $entityContentField)
    {
        $extensionAttributes = $homepage->getExtensionAttributes();
        if (!is_object($extensionAttributes)) {
            $extensionAttributes = $this->homepageExtensionFactory->create();
        }
        $awEntityFields = $extensionAttributes->getAwEntityFields() ?: [];
        $awEntityFields[HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT] = $entityContentField;

        $extensionAttributes->setAwEntityFields($awEntityFields);
        $homepage->setExtensionAttributes($extensionAttributes);
    }
}