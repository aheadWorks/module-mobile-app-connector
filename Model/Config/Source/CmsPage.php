<?php

namespace Aheadworks\MobileAppConnector\Model\Config\Source;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class for CmsPage
 */
class CmsPage implements OptionSourceInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var array
     */
    private $options;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            try {
                $this->options = [
                    [
                        'value' => 0,
                        'label' => __('Not set'),
                    ]
                ];

                $this->searchCriteriaBuilder->addFilter(PageInterface::IS_ACTIVE, true, 'eq');
                $result = $this->pageRepository->getList($this->searchCriteriaBuilder->create());

                foreach ($result->getItems() as $page) {
                    $this->options[] = [
                        'value' => $page->getId(),
                        'label' => $page->getTitle(),
                    ];
                }
            } catch (LocalizedException $e) {
                // do nothing
                throw $e;
            }
        }
        return $this->options;
    }
}
