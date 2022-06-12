<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Card\CardConfig;

final class CardConfigTest extends TestCase
{
    public function testCanSetIdentifier()
    {
        $identifier = 'test';
        $config = new CardConfig(['identifier' => $identifier]);

        $this->assertSame($identifier, $config->identifier);
    }
}