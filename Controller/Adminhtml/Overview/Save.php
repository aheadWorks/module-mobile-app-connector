<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview;

use Aheadworks\MobileAppConnector\Model\Overview\AppOverViewModel;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Exception;

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
     * @param Context $context
     * @param AppOverViewModel $overViewConfig
     */
    public function __construct(
        Context $context,
        AppOverViewModel $overViewConfig
    ) {
        parent::__construct($context);
        $this->overViewConfig = $overViewConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            try {
                if (!isset($data['aw_tenant_id'])) {
                    $this->messageManager->addErrorMessage('Tenant id should not be empty');
                    return $resultRedirect->setPath('*/*/index/flag/tenant');
                }
                $this->overViewConfig->save($data);
                $this->messageManager->addSuccessMessage(__('Tenant id was successfully saved.'));
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the tenant id.')
                );
            }
            return $resultRedirect->setPath('*/*/index/flag/tenant');
        }
        return $resultRedirect->setPath('*/*/index/flag/tenant');
    }
}
