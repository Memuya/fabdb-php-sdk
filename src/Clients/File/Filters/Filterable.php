<?php

namespace Memuya\Fab\Clients\File\Filters;

interface Filterable
{
    /**
     * Determine if the filter can be applied.
     *
     * @param array<string, mixed> $filters
     * @return bool
     */
    public function canResolve(array $filters): bool;

    /**
     * Apply the filter to the query.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed> $filter
     * @return array
     */
    public function applyTo(array $data, array $filters): array;
}
