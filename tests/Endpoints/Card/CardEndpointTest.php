<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Card\CardConfig;
use Memuya\Fab\Endpoints\Card\CardEndpoint;

final class CardEndpointTest extends TestCase
{
    public function testRouteIsSetCorrectly()
    {
        $endpoint = new CardEndpoint(new CardConfig(['identifier' => 'test']));

        $this->assertIsString($endpoint->getRoute());
        $this->assertSame('/cards/test', $endpoint->getRoute());
    }
}