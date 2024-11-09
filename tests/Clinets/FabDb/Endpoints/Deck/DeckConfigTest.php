<?php

use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckConfig;
use PHPUnit\Framework\TestCase;

final class DeckConfigTest extends TestCase
{
    public function testCanSetSlug()
    {
        $slug = 'test';
        $config = new DeckConfig(['slug' => $slug]);

        $this->assertSame($slug, $config->slug);
    }
}
