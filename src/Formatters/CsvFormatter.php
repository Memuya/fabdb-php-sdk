<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Formatters\Formatter;

class CsvFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function getContentType(): string
    {
        return 'text/csv';
    }

    /**
     * @inheritDoc
     */
    public function format(string $data): mixed
    {
        return $data;
    }
}