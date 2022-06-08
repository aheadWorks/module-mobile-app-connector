<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\ViewModel\Widget;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Config ViewModel for Template
 */
class Config implements ArgumentInterface
{
    const SHOW_WISHLIST = false;
    const SHOW_COMPARE = false;
    const SHOW_REVIEWS_RATING = false;

    /**
     * Is show Wishlist for Template
     *
     * @return bool
     */
    public function isShowWishlist(): bool
    {
        return self::SHOW_WISHLIST;
    }

    /**
     * Is show Compare for Template
     *
     * @return bool
     */
    public function isShowCompare(): bool
    {
        return self::SHOW_COMPARE;
    }

    /**
     * Is show Rating for Template
     *
     * @return bool
     */
    public function isShowReviewsRating(): bool
    {
        return self::SHOW_REVIEWS_RATING;
    }
}
