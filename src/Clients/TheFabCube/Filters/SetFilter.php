<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class SetFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['set']) && ! is_null($filters['set']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            foreach ($card['printings'] as $printing) {
                if ($printing['set_id'] === $filters['set']) {
                    return true;
                }
            }

            return false;
        });
    }
}
