<?php

use Memuya\Fab\Clients\FabDb\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Cards\CardsEndpoint;
use PHPUnit\Framework\TestCase;

final class CardsEndpointTest extends TestCase
{
    public function testRouteIsSetCorrectly()
    {
        $endpoint = new CardsEndpoint(new CardsConfig(['cost' => '2']));

        $this->assertIsString($endpoint->getRoute());
        $this->assertSame('/cards?page=1&cost=2', $endpoint->getRoute());
    }
}
