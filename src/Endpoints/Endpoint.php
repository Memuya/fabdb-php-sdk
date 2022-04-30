<?php

namespace Memuya\Fab\Endpoints;

interface Endpoint
{
    /**
     * Return the route name.
     *
     * @return string
     */
    public function getRoute();
}