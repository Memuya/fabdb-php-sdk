<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\Support\FiltersData;

class InteractsWithKeywordsFilter implements Filterable
{
    use FiltersData;
    
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['interacts_with_keywords']) && ! is_null($filters['interacts_with_keywords']);
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
                dataKey: 'interacts_with_keywords',
                filterKey: 'interacts_with_keywords',
            );
        });
    }
}
