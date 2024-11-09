<?php

namespace Memuya\Fab\Clients\FabDb\Endpoints\Cards;

use Memuya\Fab\Clients\Endpoint;
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
        return sprintf('/cards?%s', $this->config->getQueryStringValues());
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getConfig(): CardsConfig
    {
        return $this->config;
    }
}
