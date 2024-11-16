<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class TypeFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['type']) && ! is_null($filters['type']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            $cardTypes = array_map(fn($type) => strtolower($type), $card['types']);
            $filterTypes = array_map(fn($type) => strtolower($type), $filters['type']);

            return count(array_intersect($cardTypes, $filterTypes)) !== 0;
        });
    }
}
