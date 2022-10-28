<?php
declare(strict_types=1);

namespace Aheadworks\MobileAppConnector\Model\Service;

use Magento\Framework\Api\Search\SearchCriteriaInterface;

/**
 * Class SearchCriteriaEditor to edit SearchCriteria
 */
class SearchCriteriaEditor
{
    /**
     * Clear similar filters to apply filter to work
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param string $fieldFilter
     * @param string $conditionFilter
     * @param array|string $valueFilter
     * @return void
     */
    public function clearSimilarFilters($searchCriteria, $fieldFilter, $conditionFilter, $valueFilter): void
    {
        $filterGroups = $searchCriteria->getFilterGroups();
        foreach ($filterGroups as $filterGroup) {
            $filters = $filterGroup->getFilters();
            $keysDelete = [];
            foreach ($filters as $keyFilter => $filter) {
                if ($fieldFilter === $filter->getField()) {
                    $isDifferentCondition = $conditionFilter !== $filter->getConditionType();
                    $isDifferentValue = $valueFilter !== $filter->getValue();
                    if ($isDifferentCondition || $isDifferentValue) {
                        $keysDelete[] = $keyFilter;
                    }
                }
            }

            foreach ($keysDelete as $keyDelete) {
                unset($filters[$keyDelete]);
            }

            $filterGroup->setFilters($filters);
        }
        $searchCriteria->setFilterGroups($filterGroups);
    }
}
