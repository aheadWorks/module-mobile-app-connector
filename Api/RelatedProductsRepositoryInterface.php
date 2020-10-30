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
     * @param string $sku
     * @return /Aheadworks\MobileAppConnector\Model\RelatedProductsManagement
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws Exception
     */
    public function getRelatedProducts($sku);
}
