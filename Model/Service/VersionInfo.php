<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\ProductMetadataInterface;

/**
 * Class Service VersionInfo
 */
class VersionInfo
{
    public const MODULE_NAME = 'Aheadworks_MobileAppConnector';
    public const MODULE_COMPOSER_FILE_NAME = 'composer.json';

    /**
     * @var ComponentRegistrarInterface
     */
    private $componentRegistrar;

    /**
     * @var ReadFactory
     */
    private $readFactory;

    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * VersionInfo constructor.
     *
     * @param ComponentRegistrarInterface $componentRegistrar
     * @param ReadFactory $readFactory
     * @param Json $jsonSerializer
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(
        ComponentRegistrarInterface $componentRegistrar,
        ReadFactory $readFactory,
        Json $jsonSerializer,
        ProductMetadataInterface $productMetadata
    ) {
        $this->componentRegistrar = $componentRegistrar;
        $this->readFactory = $readFactory;
        $this->jsonSerializer = $jsonSerializer;
        $this->productMetadata = $productMetadata;
    }

    /**
     * Get module version from composer file
     *
     * @param string $moduleName
     * @return string
     * @throws LocalizedException
     */
    public function getModuleVersion($moduleName = self::MODULE_NAME): string
    {
        try {
            $path = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, $moduleName);
            $directoryRead = $this->readFactory->create($path);
            $composerJsonData = $directoryRead->readFile(self::MODULE_COMPOSER_FILE_NAME);
            $data = $this->jsonSerializer->unserialize($composerJsonData);

            return $data['version'];
        } catch (\Exception $ex) {
            throw new LocalizedException(
                __('Read module version from composer file exception: "%1"', $ex->getMessage()),
                $ex
            );
        }
    }

    /**
     * Get magento version
     *
     * @return string
     */
    public function getMagentoVersion(): string
    {
        return implode(' ', [
            $this->productMetadata->getName(),
            $this->productMetadata->getEdition(),
            $this->productMetadata->getVersion()
        ]);
    }
}
