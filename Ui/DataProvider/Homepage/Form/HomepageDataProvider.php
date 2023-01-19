<?php
namespace Aheadworks\MobileAppConnector\Ui\DataProvider\Homepage\Form;

use Aheadworks\Buildify\Api\Data\EntityFieldInterface;
use Aheadworks\Buildify\Model\Buildify\Entity\LoadHandler;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Api\Data\HomepageExtensionFactory;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterfaceFactory;

/**
 * Class for HomepageDataProvider
 */
class HomepageDataProvider extends AbstractDataProvider
{
    /**
     * @var HomepageInterfaceFactory
     */
    private $homepageFactory;

    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * @var LoadHandler
     */
    private $loadHandler;
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * HomepageDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param HomepageInterfaceFactory $homepageFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param LoadHandler $loadHandler
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        HomepageInterfaceFactory $homepageFactory,
        DataObjectProcessor $dataObjectProcessor,
        LoadHandler $loadHandler,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->homepageFactory = $homepageFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->loadHandler = $loadHandler;
        $this->request = $request;
    }

    /**
     * Get homepage data
     *
     * @return array
     */
    public function getData()
    {
        $data = [];
        $fieldKey = HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT;
        /** @var HomepageInterface $homepage */
        $homepage = $this->homepageFactory->create();

        $homepageData =  $this->dataObjectProcessor->buildOutputDataArray(
            $homepage,
            HomepageInterface::class
        );

        $awEntityFieldObj = $this->loadHandler->load(
            HomepageInterface::HOME_PAGE_BUILDIFY_ID,
            $fieldKey
        );
        $responseData = $this->dataObjectProcessor->buildOutputDataArray(
            $awEntityFieldObj,
            EntityFieldInterface::class
        );

        $homepageData['extension_attributes']['aw_entity_fields'][$fieldKey] = $responseData;

        $appOverViewFlag = $this->request->getParam($this->getRequestFieldName());
        $data[$appOverViewFlag] = $homepageData;

        return $data;
    }

    /**
     * Add filter
     *
     * @param array $filter
     * @return array
     */
    public function addFilter(Filter $filter)
    {
        return $this;
    }
}
