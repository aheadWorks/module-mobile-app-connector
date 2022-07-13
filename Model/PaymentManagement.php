<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model;

use Aheadworks\MobileAppConnector\Api\PaymentManagementInterface;
use Aheadworks\MobileAppConnector\Model\Service\Encryption;
use Magento\Framework\UrlInterface;
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
     * @var JsonSerializer
     */
    private $jsonSerializer;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * PaymentManagement constructor.
     *
     * @param Encryption $encryption
     * @param JsonSerializer $jsonSerializer
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Encryption $encryption,
        JsonSerializer $jsonSerializer,
        UrlInterface $urlBuilder
    ) {
        $this->encryption = $encryption;
        $this->jsonSerializer = $jsonSerializer;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritDoc
     */
    public function generatePaymentLink(string $cartId, int $storeId = null): string
    {
        $encryptedCartId = $this->encryption->encryptUrlParam($cartId);
        if ($storeId) {
            $this->urlBuilder->setScope($storeId);
        }

        $link = $this->urlBuilder->getUrl(
            'aw_mobile_app/payment',
            ['_current' => false,'_use_rewrite' => true, '_query' => ['id' => $encryptedCartId]]
        );

        return $this->jsonSerializer->serialize(['link' => $link . '#payment']);
    }
}
