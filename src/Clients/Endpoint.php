<?php

namespace Memuya\Fab\Clients;

use Memuya\Fab\Enums\HttpMethod;

/**
 * Used to define a contract for any client that requires comminucation with an API.
 */
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
     * @return Config
     */
    public function getConfig(): Config;
}
