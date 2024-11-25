<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\Support\FiltersData;

class AbilitiesAndEffectsKeywordsFilter implements Filterable
{
    use FiltersData;

    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['ability_and_effect_keywords']) && is_array($filters['ability_and_effect_keywords']);
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
                dataKey: 'ability_and_effect_keywords',
                filterKey: 'ability_and_effect_keywords',
            );
        });
    }
}
