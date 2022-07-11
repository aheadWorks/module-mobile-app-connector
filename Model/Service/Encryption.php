<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

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
     * @param string $param
     * @return string
     */
    public function encryptUrlParam(string $param)
    {
        $encryptedStr = $this->encryptor->encrypt($param);
        return $this->urlEncoder->encode($encryptedStr);
    }

    /**
     * @param string $hash
     * @return string
     */
    public function decryptUrlParam(string $hash)
    {
        $decodedHash = $this->urlDecoder->decode($hash);
        $decodedHash = str_replace(" ", "+", $decodedHash);
        return $this->encryptor->decrypt($decodedHash);
    }
}
