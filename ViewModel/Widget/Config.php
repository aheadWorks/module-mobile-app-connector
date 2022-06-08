<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\ViewModel\Widget;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Config ViewModel for Template
 */
class Config implements ArgumentInterface
{
    /**
     * @var bool
     */
    private $isShowWishlist = false;

    /**
     * @var bool
     */
    private $isShowCompare = false;

    /**
     * @var bool
     */
    private $isShowRating = false;

    /**
     * Set Is show Wishlist
     *
     * @param bool $value
     * @return $this
     */
    public function setShowWishlist(bool $value): Config
    {
        $this->isShowWishlist = $value;
        return $this;
    }

    /**
     * Set Is show Compare
     *
     * @param bool $value
     * @return $this
     */
    public function setShowCompare(bool $value): Config
    {
        $this->isShowCompare = $value;
        return $this;
    }

    /**
     * Set Is show Rating
     *
     * @param bool $value
     * @return $this
     */
    public function setShowRating(bool $value): Config
    {
        $this->isShowRating = $value;
        return $this;
    }

    /**
     * Is show Wishlist for Template
     *
     * @return bool
     */
    public function isShowWishlist(): bool
    {
        return $this->isShowWishlist;
    }

    /**
     * Is show Compare for Template
     *
     * @return bool
     */
    public function isShowCompare(): bool
    {
        return $this->isShowCompare;
    }

    /**
     * Is show Rating for Template
     *
     * @return bool
     */
    public function isShowReviewsRating(): bool
    {
        return $this->isShowRating;
    }
}
