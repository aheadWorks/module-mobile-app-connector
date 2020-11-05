<?php
namespace Aheadworks\MobileAppConnector\Ui\Component;

use Aheadworks\MobileAppConnector\Model\Config as OverViewConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class AppOverViewDataProvider
 * @package Aheadworks\MobileAppConnector\Ui\Component
 */
class AppOverViewDataProvider extends AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var OverViewConfig
     */
    private $overViewConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param OverViewConfig $overViewConfig
     * @param RequestInterface $request
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        $primaryFieldName,
        $requestFieldName,
        OverviewConfig $overViewConfig,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor,
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
        $this->overViewConfig = $overViewConfig;
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $dataFromForm = $this->dataPersistor->get(OverViewConfig::AW_MAC_OVERVIEW);
        $overView = $this->request->getParam($this->getRequestFieldName());
        if (!empty($dataFromForm)) {
            $data[$overView] = $dataFromForm;
            $this->dataPersistor->clear(OverViewConfig::AW_MAC_OVERVIEW);
        } else {
            if ($overView) {
                $formData[OverViewConfig::AW_TENANT_ID]= $this->overViewConfig->getTenantId();
                $data[$overView] = $formData;
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
