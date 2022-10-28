<?php
namespace Aheadworks\MobileAppConnector\Ui\Component;

use Aheadworks\MobileAppConnector\Api\AppOverViewRepositoryInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class AppOverViewDataProvider
 * @package Aheadworks\MobileAppConnector\Ui\Component
 */
class AppOverViewDataProvider extends AbstractDataProvider
{
    /**#@+
     * Constants defined for keys of the data array.
     */
    const AW_TENANT_ID = 'aw_tenant_id';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var AppOverViewRepositoryInterface
     */
    private $appOverViewRepository;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param RequestInterface $request
     * @param AppOverViewRepositoryInterface $appOverViewRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        $primaryFieldName,
        $requestFieldName,
        RequestInterface $request,
        AppOverViewRepositoryInterface $appOverViewRepository,
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
        $this->request = $request;
        $this->appOverViewRepository = $appOverViewRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $tenantId= $this->appOverViewRepository->getAppTenantId();
        $appOverViewFlag = $this->request->getParam($this->getRequestFieldName());
        if ($appOverViewFlag) {
            $data[$appOverViewFlag][self::AW_TENANT_ID] = $tenantId;
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
