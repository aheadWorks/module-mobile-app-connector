<?php
namespace Aheadworks\MobileAppConnector\Ui\DataProvider\Preferences\Form;

use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class PreferencesDataProvider
 * @package Aheadworks\MobileAppConnector\Ui\DataProvider\Preferences\Form
 */
class PreferencesDataProvider extends AbstractDataProvider
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var PreferencesConfig
     */
    private $PreferencesConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DataPersistorInterface $dataPersistor
     * @param PreferencesConfig $PreferencesConfig
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataPersistorInterface $dataPersistor,
        PreferencesConfig $PreferencesConfig,
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
        $this->PreferencesConfig = $PreferencesConfig;
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $dataFromForm = $this->dataPersistor->get('aw_app_data'); //
        if (!empty($dataFromForm)) {
            if (isset($dataFromForm)) {
                $data['preferences'] = $dataFromForm;
            } else {
                $data[null] = $dataFromForm;
            }
            $this->dataPersistor->clear('aw_app_data');
        } else {
            $appPreferences = $this->request->getParam($this->getRequestFieldName());
            if ($appPreferences) {
                $formData[PreferencesConfig::APP_NAME] = $this->PreferencesConfig->getAppName();
                $formData[PreferencesConfig::LOGO]= $this->PreferencesConfig->getLogo();
                $formData[PreferencesConfig::FONT_FAMILY]= $this->PreferencesConfig->getFontFamily();
                $formData[PreferencesConfig::COLOR_PREFERENCE]= $this->PreferencesConfig->getColorPreference();
                $formData[PreferencesConfig::POLICY_PAGE]= $this->PreferencesConfig->getPolicyPage();
                $formData[PreferencesConfig::CONTACT_PAGE]= $this->PreferencesConfig->getContactPage();

                $data[$appPreferences] = $formData;
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(Filter $filter)
    {
        return $this;
    }
}
