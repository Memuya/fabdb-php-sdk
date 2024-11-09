<?php

use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckEndpoint;
use PHPUnit\Framework\TestCase;

final class DeckEndpointTest extends TestCase
{
    public function testRouteIsSetCorrectly()
    {
        $endpoint = new DeckEndpoint(new DeckConfig(['slug' => 'test']));

        $this->assertIsString($endpoint->getRoute());
        $this->assertSame('/decks/test', $endpoint->getRoute());
    }
}
