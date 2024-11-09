<?php

namespace Memuya\Fab;

use Memuya\Fab\Clients\Client;

class FleshAndBlood
{
    /**
     * The Client used to communicate with the API.
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
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
