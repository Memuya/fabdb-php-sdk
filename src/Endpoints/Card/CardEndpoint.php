<?php

namespace Memuya\Fab\Endpoints\Card;

use Memuya\Fab\Enums\HttpMethod;
use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Endpoints\Card\CardConfig;

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