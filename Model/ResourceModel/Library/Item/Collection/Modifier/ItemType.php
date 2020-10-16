<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;
use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Info\Resolver as InfoResolver;
/**
 * Class ItemType
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class ItemType implements ModifierInterface
{
    /**
     * @var aditionalResolver
     */
    private $aditionalResolver;

    /**
     * @param aditionalResolver $aditionalResolver
     */
    public function __construct(
        InfoResolver $aditionalResolver
    ) {
        $this->aditionalResolver = $aditionalResolver;
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
                $this->aditionalResolver->getItemType($item)
            ); 
        }
        return $item;
    }
}
