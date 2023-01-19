<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Aheadworks\MobileAppConnector\Model\Resolver\DataProvider\ShareWishList as ShareWishListProvider;

/**
 * Class for ShareWishList
 */
class ShareWishList implements ResolverInterface
{
    /**
     * @var ShareWishListProvider
     */
    private $shareWishListDataProvider;

    /**
     * @param ShareWishListProvider $shareWishListDataProvider
     */
    public function __construct(
        ShareWishListProvider $shareWishListDataProvider
    ) {
        $this->shareWishListDataProvider = $shareWishListDataProvider;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws LocalizedException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $emails = $args['input']['emails'];
        $message = $args['input']['message'];

        $success_message = $this->shareWishListDataProvider->shareWishList(
            $emails,
            $message
        );
        return $success_message;
    }
}
