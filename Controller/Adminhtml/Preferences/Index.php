<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Preferences index controller
 */
class Index extends AbstractAction
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
  
    /**
     * Preferences index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::app_preferences'
        )->addBreadcrumb(
            __('Application Preferences'),
            __('Application Preferences')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Application Preferences'));
        return $resultPage;
    }
}
