<?php
namespace Aheadworks\MobileAppConnector\Api;
use Exception;

/**
 * Interface RelatedProductsRepositoryInterface
 * @api
 */
interface RelatedProductsRepositoryInterface
{
    /**
     * Return related products
     *
     * @param int $customerId
     * @param string $sku
     * @param int|null $storeId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws Exception
     */
    public function getRelatedProducts($customerId, $sku, $storeId = null);
}
