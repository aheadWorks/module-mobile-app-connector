<?php
namespace Aheadworks\MobileAppConnector\Model\AppLogo;

use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Info
 * @package Aheadworks\MobileAppConnector\Model\AppLogo
 */
class Info
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var Mime
     */
    private $fileMime;

    /**
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Mime $fileMime
     */
    public function __construct(
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Mime $fileMime
    ) {
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->fileMime = $fileMime;
    }
    /**
     * Get file url
     *
     * @param string $file
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl($file)
    {
        $file = ltrim(str_replace('\\', '/', $file), '/');
        $storeBaseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $storeBaseUrl . PreferencesConfig::APP_LOGO . '/' . $file;
    }

    /**
     * Get WriteInterface instance
     *
     * @return WriteInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }
}
