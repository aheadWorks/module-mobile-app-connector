<?php
namespace Aheadworks\MobileAppConnector\Model\Upload;

use Magento\MediaStorage\Model\File\UploaderFactory;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Aheadworks\MobileAppConnector\Model\Upload\Info;
use Aheadworks\MobileAppConnector\Model\Url\Builder;
/**
 * Class ImageUploader
 * @package Aheadworks\MobileAppConnector\Model
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
     * @var Builder
     */
    protected $urlBuilder;

    /**
     * @param UploaderFactory $uploaderFactory
     * @param Builder $urlBuilder
     * @param Info $info
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Builder $urlBuilder,
        Info $info
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->urlBuilder = $urlBuilder;
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

            $result['url'] = $this->urlBuilder->getAppLogoUrl($result['file']);
            $result['file_name'] = $result['file'];
            $result['id'] = base64_encode($result['file_name']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $result;
    }
    public function getAllowedFileExtensions(){
        return ['jpg', 'jpeg', 'gif', 'png'];
    }
}
