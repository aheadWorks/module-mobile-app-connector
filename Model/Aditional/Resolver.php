<?php
namespace Aheadworks\MobileAppConnector\Model\Aditional;

use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Manager;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Checker as DigitalMediaItemChecker;
/**
 * Class Resolver
 *
 * @package Aheadworks\MobileAppConnector\Model\Url
 */
class Resolver
{
 
    /**#@+
     * Constants defined for check the item type
     */
    const OTHER_TYPE = 'other';
    const PDF_TYPE = 'book';
    const MP3_TYPE = 'audio';
    const MP4_TYPE = 'video';

    /**
     * @var moduleManager
     */
    private $moduleManager;

    /**
     * @var itemChecker
     */
    private $itemChecker;

    /**
     * @param Provider $itemProvider
     * @param DigitalMediaItemChecker $itemChecker
     */
    public function __construct(
        Manager $moduleManager,
        DigitalMediaItemChecker $itemChecker
    )
    {
        $this->moduleManager = $moduleManager;
        $this->itemChecker = $itemChecker;
    }

    /**
     * Retrieve item file type
     *
     * @param string $linkFile
     * @return string
     */
    public function getItemType($linkFile)
    {
        $type = self::OTHER_TYPE;
        $ext = pathinfo($linkFile, PATHINFO_EXTENSION);
        if($ext == 'PDF' || $ext == 'pdf'){
            $type = self::PDF_TYPE;
        }
        if($ext == 'mp3' || $ext == 'MP3'){
            $type = self::MP3_TYPE;
        }
        if($ext == 'mp4' || $ext == 'MP4'){
            $type = self::MP4_TYPE;
        }
       return $type;
    }

    /**
     * Retrieve item file type
     *
     * @param string $numberOfDownloadsUsed
     * @param string $numberOfDownloadsBought
     * @return string
     */
    public function getRemaningDownload($numberOfDownloadsUsed, $numberOfDownloadsBought){
        
        if ($numberOfDownloadsBought) {
                $remainingDownloads = $numberOfDownloadsBought -$numberOfDownloadsUsed;
            } else {
                $remainingDownloads = __('Unlimited');
        }
        return $remainingDownloads;
    }

     /**
     * Retrieve  file downloadble
     *
     * @param  Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface $item
     * @return bool
     */
    public function getIsDownloadble($item){

        $isDownloadble = true;
        if($this->moduleManager->isDigitalMediaModuleEnabled()){
            if($this->itemChecker->isLibraryItem($item)){
               $isDownloadble = false;
            }
        }
        return $isDownloadble;
    }
}
