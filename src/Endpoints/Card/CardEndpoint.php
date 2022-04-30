<?php

namespace Memuya\Fab\Endpoints\Card;

use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Endpoints\Card\CardConfig;

class CardEndpoint implements Endpoint
{
    private CardConfig $config;

    public function __construct(CardConfig $config)
    {
        $this->config = $config;
    }

    public function getRoute()
    {
        return sprintf('/cards/%s', $this->config->identifier);
    }
}