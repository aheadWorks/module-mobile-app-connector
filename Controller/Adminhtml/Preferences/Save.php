<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences;

use Aheadworks\MobileAppConnector\Model\ImageUploader;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\FlagManager;

/**
 * Class Save
 * @package Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences
 */

class Save extends \Magento\Backend\App\Action
{
    /**
     * Flag code for App name.
     */
    const APP_NAME = 'app_name';
    /**
     * Flag code for App logo.
     */
    const LOGO = 'logo';
    /**
     * Flag code for Font family.
     */
    const FONT_FAMILY = 'font_family';
    /**
     * Flag code for Color Preference.
     */
    const COLOR_PREFERENCE = 'color_preference';
    /**
     * Flag code for Policy Page.
     */
    const POLICY_PAGE = 'policy_page';
    /**
     * Flag code for Contact Page.
     */
    const CONTACT_PAGE = 'contact_page';

    /**
     * @var FlagManager
     */
    private $flagManager;
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /** @var \Magento\Framework\View\Result\PageFactory  */
    protected $resultPageFactory;
    public function __construct(
        Context $context,
        FlagManager $flagManager,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->flagManager = $flagManager;
        $this->imageUploader = $imageUploader;
    }

    /**
     *
     * @return \Magento\Framework\View\Result\Page
     * @throws Exception
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        if (!empty($post)) {
            try {
                if (isset($post['image'][0]['name']) && isset($post['image'][0]['tmp_name'])) {
                    $post['image'] = $post['image'][0]['name'];
                    $this->imageUploader->moveFileFromTmp($post['image']);
                } elseif (isset($post['image'][0]['name']) && !isset($post['image'][0]['tmp_name'])) {
                    $post['image'] = $post['image'][0]['name'];
                } else {
                    $post['image'] = '';
                }
                if (!empty($post['app_name'])) {
                    $this->flagManager
                        ->saveFlag(self::APP_NAME, $post['app_name']);
                }
                if (!empty($post['app_name'])) {
                    $this->flagManager
                        ->saveFlag(self::LOGO, $post['image']);
                }
                if (!empty($post['font_family'])) {
                    $this->flagManager
                        ->saveFlag(self::FONT_FAMILY, $post['font_family']);
                }
                if (!empty($post['color_preference'])) {
                    $this->flagManager
                    ->saveFlag(self::COLOR_PREFERENCE, $post['color_preference']);
                }
                if (!empty($post['policy_page'])) {
                    $this->flagManager
                    ->saveFlag(self::POLICY_PAGE, $post['policy_page']);
                }
                if (!empty($post['contact_page'])) {
                    $this->flagManager
                    ->saveFlag(self::CONTACT_PAGE, $post['contact_page']);
                }
                $this->messageManager->addSuccessMessage(__('App data saved successfully'));
                return $resultRedirect;
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the App data'));
            }
        }
        return $resultRedirect;
    }
}
