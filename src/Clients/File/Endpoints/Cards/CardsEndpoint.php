<?php

namespace Memuya\Fab\Clients\File\Endpoints\Cards;

use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Enums\HttpMethod;

class CardsEndpoint implements Endpoint
{
    private CardsConfig $config;

    public function __construct(CardsConfig $config)
    {
        $this->config = $config;
    }

    public function getRoute(): string
    {
        return '/app/cards.json';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::NONE;
    }

    public function getConfig(): CardsConfig
    {
        return $this->config;
    }
}
