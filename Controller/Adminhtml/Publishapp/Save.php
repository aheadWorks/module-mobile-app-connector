<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Publishapp;

use Aheadworks\MobileAppConnector\Model\Publishapp\AppPublicModel;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Aheadworks\MobileAppConnector\Ui\DataProvider\Publishapp\Form\PublishappDataProvider;

/**
 * Class for Save
 */
class Save extends AbstractAction
{
    /**
     * @var AppPublicModel
     */
    private $appPublish;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param Context $context
     * @param AppPublicModel $appPublish
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        AppPublicModel $appPublish,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->appPublish = $appPublish;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Publishapp save action
     *
     * @return string
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl()); // phpcs:ignore

        $data = $this->getRequest()->getPostValue();
        if (!empty($data)) {
            try {
                $this->appPublish->save($data);
                $this->messageManager->addSuccessMessage(__('App data saved successfully'));
                $this->dataPersistor->clear(PublishappDataProvider::DATA_KEY);
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the App data'));
                $this->dataPersistor->set(PublishappDataProvider::DATA_KEY, $data);
            }
        }
        return $resultRedirect;
    }
}
