<?php
namespace Aheadworks\MobileAppConnector\Block\Adminhtml\OverView;

/**
 * Class StoreLogo
 * @package Aheadworks\MobileAppConnector\Block\Adminhtml\OverView
 */
class StoreLogo extends \Magento\Backend\Block\Template
{

   /**
    * Block template.
    * @var string
    */
    protected $_template = 'store_logo.phtml';

    const PLAY_STORE_URL ='https://play.google.com/store/apps';

    const APP_STORE_URL ='https://apps.apple.com';
}
