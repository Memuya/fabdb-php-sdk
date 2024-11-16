<?php

namespace Memuya\Fab\Clients;

interface Client
{
    /**
     * Return a filtered list of cards.
     *
     * @param array<string, mixed> $filters
     * @return mixed
     */
    public function getCards(array $filters = []): mixed;

    /**
     * Return information on a card.
     *
     * @param string $identifier
     * @param string $key
     * @return mixed
     */
    public function getCard(string $identifier, string $key): mixed;

    /**
     * Return information on the given deck.
     *
     * @param string $slug
     * @return mixed
     */
    public function getDeck(string $slug): mixed;
}
