<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\FileSystem\Filetype;
/**
 * Class ItemType
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class ItemType implements ModifierInterface
{
    /**
     * @var filetypeChecker
     */
    private $filetypeChecker;

    /**
     * @param filetypeChecker $filetypeChecker
     */
    public function __construct(
        Filetype $filetypeChecker
    ) {
        $this->filetypeChecker = $filetypeChecker;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if(isset($item['link_file']) && isset($item['link_url']) )
        {
            $item->setData(
                LibraryItemInterface::TYPE,
                $this->filetypeChecker->getItemType($item)
            ); 
        }
        return $item;
    }
}
