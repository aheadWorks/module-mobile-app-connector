<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
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
    * Load the page defined in view/adminhtml/layout/mobileappconnector_preferences_index.xml
    * @return \Magento\Framework\View\Result\Page
    */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::app_preferences'
        )->addBreadcrumb(
            __('Preferences'),
            __('Preferences')
        )->addBreadcrumb(
            __('Preferences'),
            __('Preferences')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('App Preferences'));
        return $resultPage;
    }
}
