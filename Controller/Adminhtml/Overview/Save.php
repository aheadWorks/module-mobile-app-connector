<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview;

use Aheadworks\MobileAppConnector\Model\Overview\AppOverViewModel;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class Save
 * @package Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::app_overview';

    /**
     * @var AppOverViewModel
     */
    private $overViewConfig;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param Context $context
     * @param AppOverViewModel $overViewConfig
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        AppOverViewModel $overViewConfig,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->overViewConfig = $overViewConfig;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();
        $param = ['flag' => 'tenant'];
        $resultRedirect->setPath('*/*/', $param);
        if ($data) {
            try {
                if (!isset($data['aw_tenant_id'])) {
                    $this->messageManager->addErrorMessage('Tenant id should not be empty');
                    return $resultRedirect;
                }
                $this->overViewConfig->save($data);
                $this->messageManager->addSuccessMessage(__('Tenant id was successfully saved.'));
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the tenant id.')
                );
            }
            $this->dataPersistor->set('aw_mac_overview', $data);
            return $resultRedirect;
        }
        return $resultRedirect;
    }
}
