<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class RarityFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['rarity']) && ! is_null($filters['rarity']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            foreach ($card['printings'] as $printing) {
                if ($printing['rarity'] === $filters['rarity']) {
                    return true;
                }
            }

            return false;
        });
    }
}
