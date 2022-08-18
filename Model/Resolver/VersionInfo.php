<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Aheadworks\MobileAppConnector\Model\Service\VersionInfo as ServiceVersionInfo;

/**
 * Class GraphQl Resolver VersionInfo
 */
class VersionInfo implements ResolverInterface
{
    /**
     * @var ServiceVersionInfo
     */
    private $serviceVersionInfo;

    /**
     * VersionInfo constructor.
     *
     * @param ServiceVersionInfo $serviceVersionInfo
     */
    public function __construct(ServiceVersionInfo $serviceVersionInfo)
    {
        $this->serviceVersionInfo = $serviceVersionInfo;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): array
    {
        return [
            'module_version' => $this->serviceVersionInfo->getModuleVersion(),
            'magento_version' => $this->serviceVersionInfo->getMagentoVersion(),
        ];
    }
}
