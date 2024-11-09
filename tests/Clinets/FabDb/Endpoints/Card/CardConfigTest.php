<?php

use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardConfig;
use PHPUnit\Framework\TestCase;

final class CardConfigTest extends TestCase
{
    public function testCanSetIdentifier()
    {
        $identifier = 'test';
        $config = new CardConfig(['identifier' => $identifier]);

        $this->assertSame($identifier, $config->identifier);
    }
}
