<?php
namespace Aheadworks\MobileAppConnector\Block\Adminhtml\OverView;

/**
 * Class for StoreLogo
 */
class StoreLogo extends \Magento\Backend\Block\Template
{

   /**
    * Block template.
    * @var string
    */
    protected $_template = 'store_logo.phtml';

    public const PLAY_STORE_URL = 'https://play.google.com/store/apps/details?id=com.aheadworks.aheadworksmobileapp';

    public const APP_STORE_URL = 'https://apps.apple.com/us/app/aheadworks-mobile-app/id1536034360?platform=iphone';

    public const QR_CODE_IMAGE_URL = 'images/qr-code.png';
}
