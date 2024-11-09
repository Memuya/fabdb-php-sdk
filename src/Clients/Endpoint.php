<?php

namespace Memuya\Fab\Clients;

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

    /**
     * Return the related config.
     *
     * @return BaseConfig
     */
    public function getConfig(): BaseConfig;
}
