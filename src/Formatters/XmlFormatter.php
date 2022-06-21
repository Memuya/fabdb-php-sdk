<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Formatters\Formatter;

class XmlFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function getContentType(): string
    {
        return 'application/xml';
    }

    /**
     * @inheritDoc
     */
    public function format(string $data): mixed
    {
        return simplexml_load_string($data);
    }
}