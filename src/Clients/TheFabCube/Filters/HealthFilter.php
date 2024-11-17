<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class HealthFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['health']) && ! is_null($filters['health']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return $card['health'] === $filters['health'];
        });
    }
}
;
