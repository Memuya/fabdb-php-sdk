<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\Support\FiltersData;

class RemovedKeywordsFilter implements Filterable
{
    use FiltersData;
    
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['removed_keywords']) && ! is_null($filters['removed_keywords']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return $this->filterIntersectsWithData(
                data: $card,
                filters: $filters,
                dataKey: 'removed_keywords',
                filterKey: 'removed_keywords',
            );
        });
    }
}
