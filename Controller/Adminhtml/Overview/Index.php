<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::app_overview';
    
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
   
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Connector List action
     *
     * @return void
     */
    public function execute()
    {
      
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::app_overview'
        )->addBreadcrumb(
            __('Overview'),
            __('Overview')
        )->addBreadcrumb(
            __('Overview'),
            __('Overview')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Overview'));
        return $resultPage;
    }
}
