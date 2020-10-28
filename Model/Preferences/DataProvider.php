<?php
namespace Aheadworks\MobileAppConnector\Model\Preferences;

use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package Aheadworks\MobileAppConnector\Model
 */
class DataProvider extends AbstractDataProvider
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
        $dataFromForm = $this->dataPersistor->get('aw_flag_preferences'); //
        if (!empty($dataFromForm)) {
            if (isset($dataFromForm)) {
                $data['preferences'] = $dataFromForm;
            } else {
                $data[null] = $dataFromForm;
            }
            $this->dataPersistor->clear('aw_flag_preferences');
        } else {
            $preferences = $this->request->getParam($this->getRequestFieldName());
            if ($preferences) {

                $formData['app_name']= $this->PreferencesConfig->getAppName();
                $formData['logo']= $this->PreferencesConfig->getLogo();
                $formData['font_family']= $this->PreferencesConfig->getFontFamily();
                $formData['color_preference']= $this->PreferencesConfig->getColorPreference();
                $formData['policy_page']= $this->PreferencesConfig->getPolicyPage();
                $formData['contact_page']= $this->PreferencesConfig->getContactPage();
                $formData = $this->convertToString(
                    $formData,
                    [
                        PreferencesConfig::APP_NAME,
                        PreferencesConfig::LOGO,
                        PreferencesConfig::FONT_FAMILY,
                        PreferencesConfig::COLOR_PREFERENCE,
                        PreferencesConfig::POLICY_PAGE,
                        PreferencesConfig::CONTACT_PAGE
                    ]
                );

                $data[$preferences] = $formData;
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

    /**
     * Convert selected fields to string
     *
     * @param [] $data
     * @param string[] $fields
     * @return string
     */
    private function convertToString($data, $fields)
    {
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                if (is_array($data[$field])) {
                    foreach ($data[$field] as $key => $value) {
                        if ($value === false) {
                            $data[$field][$key] = '0';
                        } else {
                            $data[$field][$key] = (string)$value;
                        }
                    }
                } else {
                    $data[$field] = (string)$data[$field];
                }
            }
        }
        return $data;
    }
}
