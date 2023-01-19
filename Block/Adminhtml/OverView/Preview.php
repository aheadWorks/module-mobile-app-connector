<?php
namespace Aheadworks\MobileAppConnector\Block\Adminhtml\OverView;

/**
 * Class for StoreLogo
 */
class Preview extends \Magento\Backend\Block\Template
{

   /**
    * Block template.
    * @var string
    */
    protected $_template = 'preview.phtml';
    
    public const PREVIEW_IMAGE_URL ='images/preview.png';
}
