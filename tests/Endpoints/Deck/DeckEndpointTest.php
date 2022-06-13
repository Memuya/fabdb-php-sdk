<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;

final class DeckEndpointTest extends TestCase
{
    public function testRouteIsSetCorrectly()
    {
        $endpoint = new DeckEndpoint(new DeckConfig(['slug' => 'test']));

        $this->assertIsString($endpoint->getRoute());
        $this->assertSame('/decks/test', $endpoint->getRoute());
    }
}