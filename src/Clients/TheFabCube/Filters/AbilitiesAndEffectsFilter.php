<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\Support\FiltersData;

class AbilitiesAndEffectsFilter implements Filterable
{
    use FiltersData;

    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['abilities_and_effects']) && is_array($filters['abilities_and_effects']);
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
                dataKey: 'abilities_and_effects',
                filterKey: 'abilities_and_effects',
            );
        });
    }
}
