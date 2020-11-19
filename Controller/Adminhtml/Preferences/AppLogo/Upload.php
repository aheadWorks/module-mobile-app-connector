<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences\AppLogo;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences\AbstractAction;

/**
 * Class Upload
 */
class Upload extends AbstractAction implements HttpPostActionInterface
{
    /**
     * Image uploader
     *
     * @var \Aheadworks\MobileAppConnector\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Aheadworks\MobileAppConnector\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Aheadworks\MobileAppConnector\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
