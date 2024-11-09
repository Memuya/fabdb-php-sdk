<?php

use Memuya\Fab\Clients\FIle\Endpoints\Card\CardConfig;
use PHPUnit\Framework\TestCase;

final class CardConfigTest extends TestCase
{
    public function testCanSetIdentifier()
    {
        $identifier = 'test';
        $config = new CardConfig(['name' => $identifier]);

        $this->assertSame($identifier, $config->name);
    }
}
