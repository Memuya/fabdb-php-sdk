<?php

namespace Memuya\Fab\Clients\FabDb\Formatters;

use Memuya\Fab\Clients\FabDb\Formatters\Formatter;

class JsonFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function getContentType(): string
    {
        return 'application/json';
    }

    /**
     * @inheritDoc
     */
    public function format(string $data): mixed
    {
        return json_decode($data);
    }
}
