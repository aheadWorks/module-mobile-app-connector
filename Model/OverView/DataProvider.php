<?php
namespace Aheadworks\MobileAppConnector\Model\OverView;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Aheadworks\MobileAppConnector\Model\OverView\Config as OverViewConfig;

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
     * @var DataProviderProcessor
     */
    private $dataProcessor;

    /**
     * @var OverViewConfig
     */
    private $overviewconfig;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DataPersistorInterface $dataPersistor
     * @param DataProviderProcessor $dataProcessor
     * @param OverviewConfig $overviewconfig
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataPersistorInterface $dataPersistor,
        OverviewConfig $overviewconfig,
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
        $this->overviewconfig = $overviewconfig;
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $dataFromForm = $this->dataPersistor->get('aw_flag_tenant');
        if (!empty($dataFromForm)) {
            if (isset($dataFromForm)) {
                $data['tenant'] = $dataFromForm;
            } else {
                $data[null] = $dataFromForm;
            }
            $this->dataPersistor->clear('aw_flag_tenant');
            } else {
            $tenant = $this->request->getParam($this->getRequestFieldName());
            if ($tenant) {
                /** @var RuleInterface $ruleDataObject */
                $formData['aw_tenant_id']= $this->overviewconfig->getTenantId();
                $formData = $this->convertToString(
                    $formData,
                    [
                        OverViewConfig::AW_TENANT_ID
                    ]
                );

                $data[$tenant] = $formData;
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
     * @return []
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
