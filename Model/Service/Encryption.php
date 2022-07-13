<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\Encryption\EncryptorInterface;

class Encryption
{
    /**
     * @var EncoderInterface
     */
    private $urlEncoder;

    /**
     * @var DecoderInterface
     */
    private $urlDecoder;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * Encryption constructor.
     *
     * @param EncoderInterface $urlEncoder
     * @param DecoderInterface $urlDecoder
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        EncoderInterface $urlEncoder,
        DecoderInterface $urlDecoder,
        EncryptorInterface $encryptor
    ) {
        $this->urlEncoder = $urlEncoder;
        $this->urlDecoder = $urlDecoder;
        $this->encryptor = $encryptor;
    }

    /**
     * Encrypt str url param
     *
     * @param string $param
     * @return string
     * @throws LocalizedException
     */
    public function encryptUrlParam(string $param): string
    {
        try {
            $encryptedStr = $this->encryptor->encrypt($param);
            return $this->urlEncoder->encode($encryptedStr);
        } catch (\Exception $ex) {
            throw new LocalizedException(__('Encrypt Url Param Exception: "%1"', $ex->getMessage()), $ex);
        }
    }

    /**
     * Decrypt str url param
     *
     * @param string $hash
     * @return string
     * @throws LocalizedException
     */
    public function decryptUrlParam(string $hash): string
    {
        try {
            $decodedHash = $this->urlDecoder->decode($hash);
            $decodedHash = str_replace(" ", "+", $decodedHash);
            return $this->encryptor->decrypt($decodedHash);
        } catch (\Exception $ex) {
            throw new LocalizedException(__('Decrypt Url Param Exception: "%1"', $ex->getMessage()), $ex);
        }
    }
}
