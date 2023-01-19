<?php
namespace Aheadworks\MobileAppConnector\Plugin\Model;

use Aheadworks\Buildify\Model\Buildify\Entity\SaveHandlerFactory;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Model\HomepageRepository;

/**
 * Class for HomepageRepositoryPlugin
 */
class HomepageRepositoryPlugin
{
    /**
     * @var SaveHandlerFactory
     */
    private $saveHandlerFactory;

    /**
     * @param SaveHandlerFactory $saveHandlerFactory
     */
    public function __construct(
        SaveHandlerFactory $saveHandlerFactory
    ) {
        $this->saveHandlerFactory = $saveHandlerFactory;
    }

    /**
     * Around save
     *
     * @param HomepageRepository $subject
     * @param callable $proceed
     * @param HomepageInterface $homepage
     * @throws \Exception
     */
    public function aroundSave($subject, $proceed, $homepage)
    {
        $saveHandler = $this->saveHandlerFactory->create(HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT);

        $saveHandler->save($homepage, $proceed);
    }
}
