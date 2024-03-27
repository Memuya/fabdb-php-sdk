<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Formatters\Formatter;
use Memuya\Fab\Enums\HttpContentType;

class JsonFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function getContentType(): HttpContentType
    {
        return HttpContentType::JSON;
    }

    /**
     * @inheritDoc
     */
    public function format(string $data): mixed
    {
        return json_decode($data);
    }
}
