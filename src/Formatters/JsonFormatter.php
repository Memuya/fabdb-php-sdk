<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Formatters\Formatter;

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