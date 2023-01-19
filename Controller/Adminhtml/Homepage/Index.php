<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Homepage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Homepage index controller
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**#@+
     * App Homepage constants
     */
    public const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::homepage_page';
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
     * Homepage index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::homepage_page'
        )->addBreadcrumb(
            __('Application Design'),
            __('Application Design')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Application Design'));

        return $resultPage;
    }
}
