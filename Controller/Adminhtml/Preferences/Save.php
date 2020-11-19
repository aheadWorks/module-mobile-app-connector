<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences;

use Aheadworks\MobileAppConnector\Model\Preferences\AppPreferencesModel;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Aheadworks\MobileAppConnector\Ui\DataProvider\Preferences\Form\PreferencesDataProvider;

/**
 * Class Save
 * @package Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences
 */

class Save extends AbstractAction
{

    /**
     * @var AppPreferencesModel
     */
    protected $appPreferences;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param AppPreferencesModel $appPreferences
     * @param DataPersistorInterface $dataPersistor
     * @param Context $context
     */
    public function __construct(
        Context $context,
        AppPreferencesModel $appPreferences,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->appPreferences = $appPreferences;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        $data = $this->getRequest()->getPostValue();
        if (!empty($data)) {
            try {
                $this->appPreferences->save($data);
                $this->messageManager->addSuccessMessage(__('App data saved successfully'));
                $this->dataPersistor->clear(PreferencesDataProvider::DATA_KEY);
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the App data'));
                $this->dataPersistor->set(PreferencesDataProvider::DATA_KEY, $data);
            }
        }
        return $resultRedirect;
    }
}
