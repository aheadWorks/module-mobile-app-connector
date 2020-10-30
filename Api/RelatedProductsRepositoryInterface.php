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
     * @param int|null $storeId
     * @param string $sku
     * @return \Aheadworks\MobileAppConnector\Model\RelatedProductsManagement
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws Exception
     */
    public function getRelatedProducts($customerId, $sku ,$storeId = null);
}
