<?php
namespace Aheadworks\MobileAppConnector\Api;

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
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRelatedProducts($sku);
}
