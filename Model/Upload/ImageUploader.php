<?php
namespace Aheadworks\MobileAppConnector\Model\Upload;

use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Magento\MediaStorage\Model\File\UploaderFactory;

/**
 * Class for ImageUploader
 */
class ImageUploader
{
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var Info
     */
    private $info;

    /**
     * @param UploaderFactory $uploaderFactory
     * @param Info $info
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Info $info
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->info = $info;
    }

    /**
     * Save file to temp directory
     *
     * @param string $fileId
     * @return array
     */
    public function saveFileToTmpDir($fileId)
    {
        try {
            $result = ['file' => '', 'size' => '', 'name' => '', 'path' => '', 'type' => ''];
            $mediaDirectory = $this->info
                ->getMediaDirectory()
                ->getAbsolutePath(PreferencesConfig::APP_LOGO);
            $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
            $uploader
                ->setAllowRenameFiles(true)
                ->setAllowedExtensions($this->getAllowedFileExtensions());
            $result = array_intersect_key($uploader->save($mediaDirectory), $result);

            $result['url'] = $this->info->getMediaUrl($result['file']);
            $result['file_name'] = $result['file'];
            $result['id'] = base64_encode($result['file_name']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $result;
    }

    /**
     * Get Allowed File Extensions
     *
     * @return string[]
     */
    public function getAllowedFileExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png'];
    }
}
