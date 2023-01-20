<?php
namespace Aheadworks\MobileAppConnector\Ui\DataProvider\Publishapp\Form;

use Aheadworks\MobileAppConnector\Model\Publishapp\Config as PublishappConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Aheadworks\MobileAppConnector\Model\Upload\Info;
use Aheadworks\MobileAppConnector\Model\Publishapp\AppPublicModel;

/**
 * Class for PublishappDataProvider
 */
class PublishappDataProvider extends AbstractDataProvider
{
    public const DATA_KEY = 'aw_app_data';
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var PublishappConfig
     */
    private $publishappConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Info
     */
    protected $uploadInfo;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DataPersistorInterface $dataPersistor
     * @param PublishappConfig $publishappConfig
     * @param Info $uploadInfo
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataPersistorInterface $dataPersistor,
        PublishappConfig $publishappConfig,
        Info $uploadInfo,
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
        $this->publishappConfig = $publishappConfig;
        $this->uploadInfo = $uploadInfo;
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
    }

    /**
     * Get publishapp data
     *
     * @return array
     */
    public function getData()
    {
        $data = [];
        $appPublishapp = $this->request->getParam($this->getRequestFieldName());
        $dataFromForm = $this->dataPersistor->get(self::DATA_KEY);
        if (!empty($dataFromForm)) {
            $data[$appPublishapp] = $dataFromForm;
            $this->dataPersistor->clear(self::DATA_KEY);
        } else {
            if ($appPublishapp) {
                $getAppTitle = $this->publishappConfig->getAppTitle();
                $getShortDescriptionOfMobileApp = $this->publishappConfig->getShortDescriptionOfMobileApp();
                $getLongDescriptionOfMobileApp = $this->publishappConfig->getLongDescriptionOfMobileApp();
                $getKeywords = $this->publishappConfig->getKeywords();
                $getSupportMail = $this->publishappConfig->getSupportMail();
                $getPolicyPolicyLink = $this->publishappConfig->getPolicyPolicyLink();
                $getSupportTelephoneNumber = $this->publishappConfig->getSupportTelephoneNumber();

                $formData[PublishappConfig::APP_TITLE] = $getAppTitle;
                $formData[PublishappConfig::SHORT_DESCRIPTION_OF_MOBILE_APP]= $getShortDescriptionOfMobileApp;
                $formData[PublishappConfig::LONG_DESCRIPTION_OF_MOBILE_APP]= $getLongDescriptionOfMobileApp;
                $formData[PublishappConfig::KEYWORDS]= $getKeywords;
                $formData[PublishappConfig::SUPPORT_MAIL]= $getSupportMail;
                $formData[PublishappConfig::PRIVACY_POLICY_LINK]= $getPolicyPolicyLink;
                $formData[PublishappConfig::SUPPORT_TELEPHONE_NUMBER]= $getSupportTelephoneNumber;
                $data[$appPublishapp] = $formData;
            }
        }

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
