<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\ThirdPartyModule\Version;

use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Provider for getting module's version
 */
class Provider
{
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
     * Provider constructor.
     *
     * @param ComponentRegistrarInterface $componentRegistrar
     * @param ReadFactory $readFactory
     * @param Json $jsonSerializer
     */
    public function __construct(
        ComponentRegistrarInterface $componentRegistrar,
        ReadFactory $readFactory,
        Json $jsonSerializer
    ) {
        $this->componentRegistrar = $componentRegistrar;
        $this->readFactory = $readFactory;
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * Get module version from composer file
     *
     * @param string $moduleName
     * @return mixed
     * @throws LocalizedException
     */
    public function getFromComposerJson(string $moduleName): string
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
}
