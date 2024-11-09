<?php

namespace Memuya\Fab;

use Memuya\Fab\Clients\ApiClient;

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
     * Return a list of cards.
     *
     * @param array $config
     * @return mixed
     */
    public function getCards(array $config = []): mixed
    {
        return $this->client->getCards($config);
    }

    /**
     * Return information on a card.
     *
     * @param string $identifier
     * @return mixed
     */
    public function getCard(string $identifier): mixed
    {
        return $this->client->getCard($identifier);
    }

    /**
     * Return information on the given deck.
     *
     * @param string $slug
     * @return mixed
     */
    public function getDeck(string $slug): mixed
    {
        return $this->client->getDeck($slug);
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
