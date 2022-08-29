<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ProductMetadataInterface;
use Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Version\Provider as VersionProvider;

/**
 * Class Service VersionInfo
 */
class VersionInfo
{
    public const MODULE_NAME = 'Aheadworks_MobileAppConnector';

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var VersionProvider
     */
    private $versionProvider;

    /**
     * VersionInfo constructor.
     *
     * @param ProductMetadataInterface $productMetadata
     * @param VersionProvider $versionProvider
     */
    public function __construct(
        ProductMetadataInterface $productMetadata,
        VersionProvider $versionProvider
    ) {
        $this->productMetadata = $productMetadata;
        $this->versionProvider = $versionProvider;
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
        return $this->versionProvider->getFromComposerJson($moduleName);
    }

    /**
     * Get magento version
     *
     * @return array
     */
    public function getMagentoVersion(): array
    {
        return [
            'name' => $this->productMetadata->getName(),
            'edition' => $this->productMetadata->getEdition(),
            'version' => $this->productMetadata->getVersion()
        ];
    }
}
