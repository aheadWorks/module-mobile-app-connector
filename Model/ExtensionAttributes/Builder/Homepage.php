<?php
namespace Aheadworks\MobileAppConnector\Model\ExtensionAttributes\Builder;

use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionFactory;

/**
 * Class for home page
 */
class Homepage
{
    /**
     * @var HomepageExtensionFactory
     */
    private $homepageExtensionFactory;

    /**
     * Homepage construct
     *
     * @param HomepageExtensionFactory $homepageExtensionFactory
     */
    public function __construct(
        HomepageExtensionFactory $homepageExtensionFactory
    ) {
        $this->homepageExtensionFactory = $homepageExtensionFactory;
    }

    /**
     * Set Aw Entity Content Field Attribute
     *
     * @param string $homepage
     * @param string $entityContentField
     */
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
