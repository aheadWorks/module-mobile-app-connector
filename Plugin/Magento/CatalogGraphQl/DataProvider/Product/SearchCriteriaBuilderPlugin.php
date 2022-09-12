<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Plugin\Magento\CatalogGraphQl\DataProvider\Product;

use Magento\CatalogGraphQl\DataProvider\Product\SearchCriteriaBuilder as Subject;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Aheadworks\MobileAppConnector\Model\Service\SearchCriteriaEditor;

/**
 * Class SearchCriteriaBuilderPlugin for apply custom filter
 */
class SearchCriteriaBuilderPlugin
{
    public const VISIBILITY_FIELD_FILTER = 'visibility';

    /**
     * @var SearchCriteriaEditor
     */
    private $searchCriteriaEditor;

    /**
     * SearchCriteriaBuilderPlugin constructor.
     *
     * @param SearchCriteriaEditor $searchCriteriaEditor
     */
    public function __construct(SearchCriteriaEditor $searchCriteriaEditor)
    {
        $this->searchCriteriaEditor = $searchCriteriaEditor;
    }

    /**
     * Build search criteria according custom filter
     *
     * @param Subject $subject
     * @param SearchCriteriaInterface $result
     * @param array $args
     * @param bool $includeAggregation
     * @return SearchCriteriaInterface
     */
    public function afterBuild(
        Subject $subject,
        SearchCriteriaInterface $result,
        array $args,
        bool $includeAggregation
    ): SearchCriteriaInterface {
        $isVisibilityFilterIncluded = isset($args['filter'][self::VISIBILITY_FIELD_FILTER]);

        if ($isVisibilityFilterIncluded) {
            $conditionFilter = array_key_first($args['filter'][self::VISIBILITY_FIELD_FILTER]);
            $valueFilter = $args['filter'][self::VISIBILITY_FIELD_FILTER][$conditionFilter];

            $this->searchCriteriaEditor->clearSimilarFilters(
                $result,
                self::VISIBILITY_FIELD_FILTER,
                $conditionFilter,
                $valueFilter
            );
        }

        return $result;
    }
}
