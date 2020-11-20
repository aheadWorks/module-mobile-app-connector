<?php
namespace Aheadworks\MobileAppConnector\Ui\DataProvider\Preferences\Form;

use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Aheadworks\MobileAppConnector\Model\Url\Builder;
use Aheadworks\MobileAppConnector\Model\Preferences\AppPreferencesModel;

/**
 * Class PreferencesDataProvider
 * @package Aheadworks\MobileAppConnector\Ui\DataProvider\Preferences\Form
 */
class PreferencesDataProvider extends AbstractDataProvider
{
    const DATA_KEY = 'aw_app_data';
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var PreferencesConfig
     */
    private $preferencesConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Builder
     */
    protected $urlBuilder;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DataPersistorInterface $dataPersistor
     * @param PreferencesConfig $preferencesConfig
     * @param Builder $urlBuilder
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataPersistorInterface $dataPersistor,
        PreferencesConfig $preferencesConfig,
        Builder $urlBuilder,
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
        $this->preferencesConfig = $preferencesConfig;
        $this->urlBuilder = $urlBuilder;
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $appPreferences = $this->request->getParam($this->getRequestFieldName());
        $dataFromForm = $this->dataPersistor->get(self::DATA_KEY);
        if (!empty($dataFromForm)) {
            $data[$appPreferences] = $dataFromForm;
            $this->dataPersistor->clear(self::DATA_KEY);
        } else {
            if ($appPreferences) {
                $formData[PreferencesConfig::APP_NAME] = $this->preferencesConfig->getAppName();
                $appLogo = [];
                $appLogoName = $this->preferencesConfig->getLogo();
                $appLogo[0]['name'] = $appLogoName;
                $appLogo[0]['url'] = $this->urlBuilder->getAppLogoUrl($appLogoName);
                $formData[AppPreferencesModel::APP_IMAGE_NAME] = $appLogo;
                $formData[PreferencesConfig::FONT_FAMILY]= $this->preferencesConfig->getFontFamily();
                $formData[PreferencesConfig::COLOR_PREFERENCE]= $this->preferencesConfig->getColorPreference();
                $formData[PreferencesConfig::POLICY_PAGE]= $this->preferencesConfig->getPolicyPageId();
                $formData[PreferencesConfig::CONTACT_PAGE]= $this->preferencesConfig->getContactPageId();

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
