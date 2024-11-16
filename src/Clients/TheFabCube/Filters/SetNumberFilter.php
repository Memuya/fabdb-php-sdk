<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class SetNumberFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['set_id']) && ! is_null($filters['set_id']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            foreach ($card['printings'] as $printing) {
                if ($printing['id'] === $filters['set_id']) {
                    return true;
                }
            }

            return false;
        });
    }
}
