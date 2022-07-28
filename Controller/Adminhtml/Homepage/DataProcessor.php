<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Homepage;

use Aheadworks\Buildify\Model\Request\FormData\Processor as FormDataProcessor;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterfaceFactory;
use Aheadworks\MobileAppConnector\Model\ExtensionAttributes\Builder\Homepage as ExtensionAttributesBuilder;
use Magento\Framework\App\RequestInterface;
use Aheadworks\MobileAppConnector\Model\Service\BuildifyExternalWidget;

/**
 * Class DataProcessor for Homepage
 */
class DataProcessor
{
    /**
     * @var HomepageInterfaceFactory
     */
    private $homepageFactory;

    /**
     * @var FormDataProcessor
     */
    private $formDataProcessor;

    /**
     * @var ExtensionAttributesBuilder
     */
    private $extensionAttributesBuilder;

    /**
     * @var BuildifyExternalWidget
     */
    private $buildifyExternalWidget;

    /**
     * DataProcessor constructor.
     *
     * @param HomepageInterfaceFactory $homepageFactory
     * @param ExtensionAttributesBuilder $extensionAttributesBuilder
     * @param FormDataProcessor $formDataProcessor
     * @param BuildifyExternalWidget $buildifyExternalWidget
     */
    public function __construct(
        HomepageInterfaceFactory $homepageFactory,
        ExtensionAttributesBuilder $extensionAttributesBuilder,
        FormDataProcessor $formDataProcessor,
        BuildifyExternalWidget $buildifyExternalWidget
    ) {
        $this->homepageFactory = $homepageFactory;
        $this->extensionAttributesBuilder = $extensionAttributesBuilder;
        $this->formDataProcessor = $formDataProcessor;
        $this->buildifyExternalWidget = $buildifyExternalWidget;
    }

    /**
     * Prepare homepage
     *
     * @param RequestInterface $request
     * @return HomepageInterface
     */
    public function prepareHomepage(RequestInterface $request)
    {
        $requestData = $request->getPostValue();
        /** @var HomepageInterface $homepage */
        $homepage = $this->homepageFactory->create();
        $homepage->setData($requestData);
        $entityContentField = $this->formDataProcessor->getEntityField(
            $request,
            HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT
        );
        $entityContentField = $this->buildifyExternalWidget->addAdditionalContent($entityContentField);
        $this->extensionAttributesBuilder->setAwEntityContentFieldAttribute($homepage, $entityContentField);

        return $homepage;
    }
}
