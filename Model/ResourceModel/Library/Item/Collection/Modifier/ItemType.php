<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\FileSystem\Filetype;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;

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
     * @param Filetype $filetypeChecker
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
        if (isset($item['link_file']) && (!empty($item['link_file']))){   
            $item->setData(
                LibraryItemInterface::TYPE,
                $this->filetypeChecker->getItemType($item)
            );
        }
        return $item;
    }
}
