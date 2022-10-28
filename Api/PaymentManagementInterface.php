<?php

namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface PaymentManagementInterface
 * @api
 */
interface PaymentManagementInterface
{
    /**
     * Generate Payment Link by Cart Id
     *
     * @param string $cartId
     * @param int|null $storeId
     * @return string
     */
    public function generatePaymentLink(string $cartId, int $storeId = null): string;
}
