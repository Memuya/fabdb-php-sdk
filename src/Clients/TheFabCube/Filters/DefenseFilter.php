<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class DefenseFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['defense']) && ! is_null($filters['defense']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return $card['defense'] === $filters['defense'];
        });
    }
}
;
