<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Overview;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Overview index controller
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**#@+
     * App overview constants
     */
    public const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::app_overview';
    /**#@-*/

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
     * Overview index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::app_overview'
        )->addBreadcrumb(
            __('Preview application'),
            __('Preview application')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Preview application'));
        return $resultPage;
    }
}
