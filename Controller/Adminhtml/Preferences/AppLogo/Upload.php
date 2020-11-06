<?php
namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences\AppLogo;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Aheadworks\MobileAppConnector\Model\ImageUploader;
use Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences\AbstractAction;

/**
 * App logo upload controller
 */
class Upload extends AbstractAction
{
    /**
     * Image uploader
     *
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $files = $this->getRequest()->getFiles()->toArray();
        try {
            $result = $this->imageUploader->saveFileToTmpDir(key($files));
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
