<?php

namespace Memuya\Fab\Formatters;

use Memuya\Fab\Enums\HttpContentType;

interface Formatter
{
    /**
     * The content type of the response.
     *
     * @return HttpContentType
     */
    public function getContentType(): HttpContentType;

    /**
     * Format the given data.
     *
     * @param string $data
     * @return mixed
     */
    public function format(string $data): mixed;
}
