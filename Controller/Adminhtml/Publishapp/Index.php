<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Publishapp;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Publishapp index controller
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
     * Publishapp index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::publish_app'
        )->addBreadcrumb(
            __('Publish application'),
            __('Publish application')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Publish application'));
        return $resultPage;
    }
}
