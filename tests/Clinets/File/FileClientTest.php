<?php

use Memuya\Fab\Clients\File\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;

final class FileClientTest extends TestCase
{
    private FileClient $client;

    public function setUp(): void
    {
        $this->client = new FileClient('/app/cards.json');
    }

    public function testCanReadFromJsonFile(): void
    {
        $cards = $this->client->readFromFile(new CardsConfig());

        $this->assertNotEmpty($cards);
    }

    public function testCanFilterResults(): void
    {
        $cards = $this->client->readFromFile(
            new CardsConfig([
                'name' => '10,000 Year Reunion',
                'pitch' => Pitch::One,
            ])
        );

        $this->assertNotEmpty($cards);
        $this->assertCount(1, $cards);
        $this->assertSame('10,000 Year Reunion', $cards[0]['name']);
    }

    public function testResultIsEmptyWhenFiltersDoNotMatchACard(): void
    {
        $cards = $this->client->readFromFile(
            new CardsConfig([
                'name' => '10,000 Year Reunion',
                'pitch' => Pitch::Two, // 10,000 Year Reunion pitches for 1.
            ])
        );

        $this->assertEmpty($cards);
    }
}
