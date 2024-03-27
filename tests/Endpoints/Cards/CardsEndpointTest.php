<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Endpoints\Cards\CardsEndpoint;

final class CardsEndpointTest extends TestCase
{
    public function testRouteIsSetCorrectly()
    {
        $endpoint = new CardsEndpoint(new CardsConfig(['cost' => '2']));

        $this->assertIsString($endpoint->getRoute());
        $this->assertSame('/cards', $endpoint->getRoute());
    }
}