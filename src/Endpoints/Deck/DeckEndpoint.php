<?php

namespace Memuya\Fab\Endpoints\Deck;

use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Endpoints\Deck\DeckConfig;

class DeckEndpoint implements Endpoint
{
    private DeckConfig $config;

    public function __construct(DeckConfig $config)
    {
        $this->config = $config;
    }

    public function getRoute()
    {
        return sprintf('/decks/%s', $this->config->slug);
    }
}