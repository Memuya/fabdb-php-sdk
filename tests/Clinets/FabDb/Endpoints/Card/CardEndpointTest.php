<?php

use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardEndpoint;
use PHPUnit\Framework\TestCase;

final class CardEndpointTest extends TestCase
{
    public function testRouteIsSetCorrectly()
    {
        $endpoint = new CardEndpoint(new CardConfig(['identifier' => 'test']));

        $this->assertIsString($endpoint->getRoute());
        $this->assertSame('/cards/test', $endpoint->getRoute());
    }
}
