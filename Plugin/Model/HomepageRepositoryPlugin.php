<?php
namespace Aheadworks\MobileAppConnector\Plugin\Model;

use Aheadworks\Buildify\Model\Buildify\Entity\SaveHandlerFactory;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\MobileAppConnector\Model\HomepageRepository;

/**
 * Class HomepageRepositoryPlugin
 * @package Aheadworks\MobileAppConnector\Plugin\Model
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