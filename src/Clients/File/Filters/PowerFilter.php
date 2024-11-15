<?php

namespace Memuya\Fab\Clients\File\Filters;

class PowerFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        // The $filters array is generated from the associated `Config` class' `Parameter` proerties.
        // If a filter is not defined in the associated `Config` class it will not be available.
        return isset($filters['power']) && ! is_null($filters['power']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return $card['power'] === $filters['power'];
        });
    }
}
;
