<?php

namespace Memuya\Fab\Endpoints\Cards;

use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Endpoints\Cards\CardsConfig;

class CardsEndpoint implements Endpoint
{
    private CardsConfig $config;

    public function __construct(CardsConfig $config)
    {
        $this->config = $config;
    }

    public function getRoute(): string
    {
        return sprintf('/cards?%s', $this->config->toQueryString());
    }
}