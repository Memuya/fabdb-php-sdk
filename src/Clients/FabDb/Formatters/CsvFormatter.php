<?php

namespace Memuya\Fab\Clients\FabDb\Formatters;

use Memuya\Fab\Clients\FabDb\Formatters\Formatter;

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
