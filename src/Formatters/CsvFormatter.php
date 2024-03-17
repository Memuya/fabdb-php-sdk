<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Formatters\Formatter;
use Memuya\Fab\Enums\HttpContentType;

class CsvFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function getContentType(): HttpContentType
    {
        return HttpContentType::CSV;
    }

    /**
     * @inheritDoc
     */
    public function format(string $data): mixed
    {
        return $data;
    }
}
