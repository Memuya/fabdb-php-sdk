<?php

namespace Memuya\Fab\Clients;

interface ApiClient
{
    /**
     * Send off the request to the given route and return the response.
     *
     * @param Endpoint $endpoint
     * @return mixed
     */
    public function sendRequest(Endpoint $endpoint): mixed;
}
