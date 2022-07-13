<?php

namespace Memuya\Fab\Endpoints;

use Memuya\Fab\Enums\HttpMethod;

interface Endpoint
{
    /**
     * Return the route name.
     *
     * @return string
     */
    public function getRoute(): string;

    /**
     * Return the HTTP request method needed for the API endpoint.
     *
     * @return HttpMethod
     */
    public function getHttpMethod(): HttpMethod;
}