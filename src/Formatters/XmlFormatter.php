<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Formatters\Formatter;
use Memuya\Fab\Enums\HttpContentType;

class XmlFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function getContentType(): HttpContentType
    {
        return HttpContentType::XML;
    }

    /**
     * @inheritDoc
     */
    public function format(string $data): mixed
    {
        return simplexml_load_string($data);
    }
}
