<?php
namespace Aheadworks\MobileAppConnector\Ui;

use Aheadworks\MobileAppConnector\Model\Config as OverViewConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class AppOverViewDataProvider
 * @package Aheadworks\MobileAppConnector\Ui
 */
class AppOverViewDataProvider extends AbstractDataProvider
{

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
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        $primaryFieldName,
        $requestFieldName,
        OverviewConfig $overViewConfig,
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
        $this->overViewConfig = $overViewConfig;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $tenant = $this->request->getParam($this->getRequestFieldName());
        if ($tenant) {
            $formData[OverViewConfig::AW_TENANT_ID]= $this->overViewConfig->getTenantId();
            $data[$tenant] = $formData;
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
