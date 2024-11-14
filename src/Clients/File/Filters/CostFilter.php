<?php

namespace Memuya\Fab\Clients\File\Filters;

class CostFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['cost']) && ! is_null($filters['cost']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return str_contains($card['cost'], $filters['cost']);
        });
    }
}
