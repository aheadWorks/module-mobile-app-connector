<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier;

use Aheadworks\MobileAppConnector\Api\Data\LibraryItemInterface;
use Aheadworks\MobileAppConnector\Model\Downloadable\Link\Purchased\Item\Resolver;
use Aheadworks\MobileAppConnector\Model\ResourceModel\Collection\ModifierInterface;

/**
 * Class GetRemainingDownload
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Library\Item\Collection\Modifier
 */
class GetRemainingDownload implements ModifierInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @param Resolver $resolver
     */
    public function __construct(
        Resolver $resolver
    ) {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData($item)
    {
        if (isset($item['number_of_downloads_bought'])) {
            $item->setData(
                LibraryItemInterface::REMAINING_DOWNLOADS,
                $this->resolver->getRemainingDownload($item)
            );
        }
        return $item;
    }
}
