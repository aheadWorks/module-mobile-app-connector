<?php
namespace Aheadworks\MobileAppConnector\Block\Adminhtml\OverView;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Logo
 * @package Aheadworks\MobileAppConnector\Block\Adminhtml\OverView
 */
class Logo extends \Magento\Backend\Block\Template
{
   
   /**
    * Block template.
    *
    * @var string
    */
    protected $_template = 'download_store_logo.phtml';

    const PLAY_STORE_URL ='https://play.google.com/store/apps';

    const APP_STORE_URL ='https://apps.apple.com';
}
