<?php

namespace Memuya\Fab\Clients\TheFabCube\Filters;

use Memuya\Fab\Clients\File\Filters\Filterable;

class CardIdFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['card_id']) && ! is_null($filters['card_id']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            foreach ($card['printings'] as $printing) {
                if ($printing['id'] === $filters['card_id']) {
                    return true;
                }
            }

            return false;
        });
    }
}
