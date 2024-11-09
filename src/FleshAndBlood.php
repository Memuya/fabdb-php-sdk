<?php

namespace Memuya\Fab;

use stdClass;
use Memuya\Fab\Clients\ApiClient;
use Memuya\Fab\Endpoints\Card\CardConfig;
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsEndpoint;

class FleshAndBlood
{
    /**
     * The Client used to communicate with the API.
     *
     * @var ApiClient
     */
    private ApiClient $client;

    /**
     * Setup.
     *
     * @param ApiClient $client
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Return a paginated list of cards.
     *
     * @param array $config
     * @return stdClass
     */
    public function getCards(array $config = []): stdClass
    {
        return $this->client->sendRequest(
            new CardsEndpoint(new CardsConfig($config))
        );
    }

    /**
     * Return information on a card.
     *
     * @param string $identifier
     * @return stdClass
     */
    public function getCard(string $identifier): stdClass
    {
        return $this->client->sendRequest(
            new CardEndpoint(new CardConfig(['identifier' => $identifier]))
        );
    }

    /**
     * Return information on the given deck.
     *
     * @param string $slug
     * @return stdClass
     */
    public function getDeck(string $slug): stdClass
    {
        return $this->client->sendRequest(
            new DeckEndpoint(new DeckConfig(['slug' => $slug]))
        );
    }

    /**
     * Return the client.
     *
     * @return ApiClient
     */
    public function getClient(): ApiClient
    {
        return $this->client;
    }
}
