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
        $overView = $this->request->getParam($this->getRequestFieldName());
        if ($overView) {
            $data[$overView] = $tenantId;
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
