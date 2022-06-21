<?php

namespace Memuya\Fab\Formatters;

interface Formatter
{
    /**
     * The content type of the response.
     *
     * @return string
     */
    public function getContentType(): string;

    /**
     * Format the given data.
     *
     * @param string $data
     * @return mixed
     */
    public function format(string $data): mixed;
}