<?php

namespace Memuya\Fab\Clients\File\Filters;

class PitchFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['pitch']) && ! is_null($filters['pitch']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return str_contains($card['pitch'], $filters['pitch']);
        });
    }
}
