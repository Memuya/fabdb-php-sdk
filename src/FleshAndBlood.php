<?php

namespace Memuya\Fab;

use stdClass;
use Memuya\Fab\Client;
use Memuya\Fab\Endpoints\Card\CardConfig;
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsEndpoint;

class FleshAndBlood
{
    /**
     * The client used to communicate with the API.
     *
     * @var Client
     */
    private Client $client;

    /**
     * Setup.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Return a paginated list of cards.
     *
     * @param array $config
     * @return mixed  Changes depending on the formatter used in Client
     */
    public function getCards(array $config = []): mixed
    {
        return $this->client->sendRequest(
            new CardsEndpoint(new CardsConfig($config))
        );
    }
    
    /**
     * Return information on a card.
     *
     * @param string $identifier
     * @return mixed  Changes depending on the formatter used in Client
     */
    public function getCard(string $identifier): mixed
    {
        return $this->client->sendRequest(
            new CardEndpoint(new CardConfig(['identifier' => $identifier]))
        );
    }

    /**
     * Return information on the given deck.
     *
     * @param string $slug
     * @return mixed  Changes depending on the formatter used in Client
     */
    public function getDeck(string $slug): mixed
    {
        return $this->client->sendRequest(
            new DeckEndpoint(new DeckConfig(['slug' => $slug]))
        );
    }

    /**
     * Return the client.
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}