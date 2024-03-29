<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\FileSystem\Filetype;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;

/**
 * Class for ItemType
 */
class ItemType implements ModifierInterface
{
    /**
     * @var Filetype
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
     * Modify data
     *
     * @param string $item
     * @return string
     */
    public function modifyData($item)
    {
        $item->setData(
            LibraryItemInterface::TYPE,
            $this->filetypeChecker->getItemType($item)
        );
        return $item;
    }
}
