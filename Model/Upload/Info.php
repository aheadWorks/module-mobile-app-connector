<?php
namespace Aheadworks\MobileAppConnector\Model\Upload;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Aheadworks\MobileAppConnector\Model\Preferences\Config as PreferencesConfig;

/**
 * Class for Info
 */
class Info
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $filesystem
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $filesystem
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->filesystem = $filesystem;
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
    /**
     * Retrieve Media Url
     *
     * @param string $imagename
     * @return string
     */
    public function getMediaUrl($imagename)
    {
        $folderName = PreferencesConfig::APP_LOGO;
        $path = $folderName . '/' . $imagename;
        $imageUrl = $this->urlBuilder
            ->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $path;
        return $imageUrl;
    }
}
