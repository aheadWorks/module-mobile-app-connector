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
     * @param int|null $storeId
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws Exception
     */
    public function getRelatedProducts($sku, $storeId = null);
}
