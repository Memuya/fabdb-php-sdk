<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;

final class DeckConfigTest extends TestCase
{
    public function testCanSetSlug()
    {
        $slug = 'test';
        $config = new DeckConfig(['slug' => $slug]);

        $this->assertSame($slug, $config->slug);
    }
}