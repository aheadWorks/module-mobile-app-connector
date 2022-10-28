<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\ViewModel\Widget;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Aheadworks\MobileAppConnector\Model\Config\Source\Carousel\Navigation;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Config ViewModel for Template
 */
class Config implements ArgumentInterface
{
    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * Config constructor.
     *
     * @param Json $jsonSerializer
     */
    public function __construct(Json $jsonSerializer)
    {
        $this->jsonSerializer = $jsonSerializer;
    }

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

    /**
     * Get Slider Options in json
     *
     * @param DataObject $block
     * @return string
     */
    public function getJsonDataSliderOptions(DataObject $block): string
    {
        $data = [
            'slidesToShow' => (int)$block->getData('slider_show_slides_count'),
            'slidesToScroll' => (int)$block->getData('slider_scroll_slides_count'),
            'speed' => (int)$block->getData('slider_animation_speed'),
            'arrows' => in_array(
                $block->getData('slider_navigation'),
                [Navigation::ARROWS_DOTS_SELECT_VAL, Navigation::ARROWS_SELECT_VAL]
            ),
            'dots' => in_array(
                $block->getData('slider_navigation'),
                [Navigation::ARROWS_DOTS_SELECT_VAL, Navigation::DOTS_SELECT_VAL]
            ),
            'pauseOnHover' => (bool)$block->getData('slider_pause_on_hover'),
            'autoplay' => (bool)$block->getData('slider_autoplay'),
            'autoplaySpeed' => (int)$block->getData('slider_autoplay_speed'),
            'infinite' => (bool)$block->getData('slider_infinite_loop'),
        ];

        return htmlentities($this->jsonSerializer->serialize($data));
    }
}
