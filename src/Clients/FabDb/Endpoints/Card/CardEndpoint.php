<?php

namespace Memuya\Fab\Clients\FabDb\Endpoints\Card;

use Memuya\Fab\Clients\Endpoint;
use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardConfig;
use Memuya\Fab\Enums\HttpMethod;

class CardEndpoint implements Endpoint
{
    private CardConfig $config;

    public function __construct(CardConfig $config)
    {
        $this->config = $config;
    }

    public function getRoute(): string
    {
        return sprintf('/cards/%s', $this->config->identifier);
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getConfig(): CardConfig
    {
        return $this->config;
    }
}
