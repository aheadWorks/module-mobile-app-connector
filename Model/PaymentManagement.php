<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\PaymentManagementInterface;
use Aheadworks\MobileAppConnector\Model\Service\Encryption;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

/**
 * Class PaymentManagement - mobile app payment
 */
class PaymentManagement implements PaymentManagementInterface
{
    /**
     * @var Encryption
     */
    private $encryption;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var JsonSerializer
     */
    private $jsonSerializer;

    /**
     * PaymentManagement constructor.
     *
     * @param Encryption $encryption
     * @param StoreManagerInterface $storeManager
     * @param JsonSerializer $jsonSerializer
     */
    public function __construct(
        Encryption $encryption,
        StoreManagerInterface $storeManager,
        JsonSerializer $jsonSerializer
    ) {
        $this->encryption = $encryption;
        $this->storeManager = $storeManager;
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * @inheritDoc
     */
    public function generatePaymentLink(string $cartId): string
    {
        $encryptedCartId = $this->encryption->encryptUrlParam($cartId);
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
        $link = $baseUrl . 'aw_mobile_app/payment?id=' . $encryptedCartId . '#payment';
        return $this->jsonSerializer->serialize(['link' => $link]);
    }
}
