<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\ViewModel\Widget;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Config ViewModel for Template
 */
class Config implements ArgumentInterface
{
    /**
     * Is show Wishlist for Template
     *
     * @param DataObject $block
     * @return bool
     */
    public function isShowWishlist(DataObject $block): bool
    {
        return (bool)$block->getData('show_wishlist');
    }

    /**
     * Is show Compare for Template
     *
     * @param DataObject $block
     * @return bool
     */
    public function isShowCompare(DataObject $block): bool
    {
        return (bool)$block->getData('show_compare');
    }

    /**
     * Is show Rating for Template
     *
     * @param DataObject $block
     * @return bool
     */
    public function isShowReviewsRating(DataObject $block): bool
    {
        return (bool)$block->getData('show_rating');
    }
}
