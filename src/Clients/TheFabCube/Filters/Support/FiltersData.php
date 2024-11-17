<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters\Support;

trait FiltersData
{
    /**
     * Determine if the filter value (an array) intersects with the data value (an array).
     *
     * @param array<string, array<string>> $data
     * @param array<string, array<string>> $filters
     * @param string $dataKey
     * @param string $filterKey
     * @return bool
     */
    public function filterIntersectsWithData(array $data, array $filters, string $dataKey, string $filterKey): bool
    {
        $cardData = array_map(fn($type) => strtolower($type), $data[$dataKey]);
        $filterData = array_map(fn($type) => strtolower($type), $filters[$filterKey]);

        return count(array_intersect($cardData, $filterData)) !== 0;
    }
}
