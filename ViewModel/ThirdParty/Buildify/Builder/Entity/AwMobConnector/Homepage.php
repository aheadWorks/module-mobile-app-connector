<?php
namespace Aheadworks\MobileAppConnector\ViewModel\ThirdParty\Buildify\Builder\Entity\AwMobConnector;

use Aheadworks\Buildify\Model\Buildify\Entity\LoadHandler;
use Aheadworks\Buildify\ViewModel\Buildify\Builder\EntityLocatorInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Model\ExtensionAttributes\Builder\Homepage as ExtensionAttributesBuilder;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterfaceFactory;

/**
 * Class for Homepage
 */
class Homepage implements EntityLocatorInterface
{
    /**
     * @var HomepageInterfaceFactory
     */
    private $homepageFactory;

    /**
     * @var ExtensionAttributesBuilder
     */
    private $extensionAttributesBuilder;

    /**
     * @var LoadHandler
     */
    private $loadHandler;

    /**
     * @param HomepageInterfaceFactory $homepageFactory
     * @param ExtensionAttributesBuilder $extensionAttributesBuilder
     * @param LoadHandler $loadHandler
     */
    public function __construct(
        HomepageInterfaceFactory $homepageFactory,
        ExtensionAttributesBuilder $extensionAttributesBuilder,
        LoadHandler $loadHandler
    ) {
        $this->homepageFactory = $homepageFactory;
        $this->extensionAttributesBuilder = $extensionAttributesBuilder;
        $this->loadHandler = $loadHandler;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        /** @var HomepageInterface $homepage */
        $homepage = $this->homepageFactory->create();

        $entityContentField = $this->loadHandler->load(
            $homepage->getId(),
            HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT
        );
        $this->extensionAttributesBuilder->setAwEntityContentFieldAttribute($homepage, $entityContentField);

        return $homepage;
    }
}
