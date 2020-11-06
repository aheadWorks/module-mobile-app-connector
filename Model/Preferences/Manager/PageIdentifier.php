<?php
namespace Aheadworks\MobileAppConnector\Model\Preferences\Manager;

use Magento\Cms\Api\PageRepositoryInterface;
/**
 * Class PageIdentifier
 *
 * @package Aheadworks\MobileAppConnector\Model\Preferences\Manager
 */
class PageIdentifier
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;
    
    /**
     * @param StoreManagerInterface $pageRepository
     */
    public function __construct(
        PageRepositoryInterface $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Get identifier of cms page
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPageIdentifierById($pageId){
        $page = $this->pageRepository->getById($pageId);  
        return $page->getIdentifier();

    }
}
