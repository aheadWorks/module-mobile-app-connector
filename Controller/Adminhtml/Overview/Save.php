<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Aheadworks\MobileAppConnector\Model\OverView\Config as OverViewConfig;
/**
 * Class Save
 * @package Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::app_overview';

    /**
     * @var OverViewConfig
     */
    private $overviewconfig;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @param Context $context
     * @param OverviewConfig $overviewconfig
     * @param DataPersistorInterface $dataPersistor
     * @param DataObjectHelper $dataObjectHelper,
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        OverviewConfig $overviewconfig,
        DataObjectHelper $dataObjectHelper
    ) {
        parent::__construct($context);
        $this->overviewconfig = $overviewconfig;
        $this->dataPersistor = $dataPersistor;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            try {
                if(isset($data['aw_tenant_id'])){
                    $tenantId = $data['aw_tenant_id'];
                }else{
                    $this->messageManager->addErrorMessage('Tenant id should not be empty');
                    return $resultRedirect->setPath('*/*/');
                }
                $this->overviewconfig->setTenantId($tenantId);
                $this->dataPersistor->set('aw_flag_tenant', $data);
                $this->messageManager->addSuccessMessage(__('Tenant id was successfully saved.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the rule data.')
                );
            }
        return $resultRedirect->setPath('*/*/');
        }
    }

}
