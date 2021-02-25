<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Homepage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Aheadworks\MobileAppConnector\Controller\Adminhtml\Homepage
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::homepage_page';

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
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobileAppConnector::homepage_page'
        )->addBreadcrumb(
            __('Home Page'),
            __('Home Page')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Home Page'));

        return $resultPage;
    }
}