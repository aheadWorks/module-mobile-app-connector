<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Aheadworks\MobileAppConnector\Model\AppOverViewManagement;
use Aheadworks\MobileAppConnector\Model\Config;

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
     * @var AppOverViewManagement
     */
    private $overViewConfig;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param Context $context
     * @param AppOverViewManagement $overViewConfig
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        AppOverViewManagement $overViewConfig,
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
        $params = ['flag' => 'overview'];
        $resultRedirect->setPath('*/*/', $params);
        if ($data) {
            try {
                if (!isset($data['aw_tenant_id'])) {
                    $this->messageManager->addErrorMessage('Tenant id should not be empty');
                    return $resultRedirect;
                }
                $this->overViewConfig->save($data);
                $this->dataPersistor->clear(Config::AW_MAC_OVERVIEW);
                $this->messageManager->addSuccessMessage(__('Tenant id was successfully saved.'));
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the tenant id.')
                );
            }
            $this->dataPersistor->set(Config::AW_MAC_OVERVIEW, $data);
            return $resultRedirect;
        }
        return $resultRedirect;
    }
}
