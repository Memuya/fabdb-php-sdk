<?php

namespace Memuya\Fab\Clients\FabDb\Endpoints\Deck;

use Memuya\Fab\Clients\Endpoint;
use Memuya\Fab\Enums\HttpMethod;
use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckConfig;

class DeckEndpoint implements Endpoint
{
    private DeckConfig $config;

    public function __construct(DeckConfig $config)
    {
        $this->config = $config;
    }

    public function getRoute(): string
    {
        return sprintf('/decks/%s', $this->config->slug);
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getConfig(): DeckConfig
    {
        return $this->config;
    }
}
