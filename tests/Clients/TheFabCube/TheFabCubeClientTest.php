<?php

use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Clients\TheFabCube\TheFabCubeClient;

final class TheFabCubeClientTest extends TestCase
{
    private string $cardsJsonFilePath;
    private TheFabCubeClient $client;

    public function setUp(): void
    {
        $this->cardsJsonFilePath = sprintf('%s/cards.json', dirname(__DIR__, 3));

        $this->client = new TheFabCubeClient($this->cardsJsonFilePath);
    }

    public function testCanReadFromJsonFile(): void
    {
        $cards = $this->client->getCards();

        $this->assertNotEmpty($cards);
    }

    public function testCanFilterResults(): void
    {
        $cards = $this->client->getCards([
            'name' => '10,000 Year Reunion',
            'pitch' => Pitch::One,
        ]);

        $this->assertNotEmpty($cards);
        $this->assertCount(1, $cards);
        $this->assertSame('10,000 Year Reunion', $cards[0]['name']);
    }

    public function testResultIsEmptyWhenFiltersDoNotMatchACard(): void
    {
        $cards = $this->client->getCards([
            'name' => '10,000 Year Reunion',
            'pitch' => Pitch::Two,
        ]);

        $this->assertEmpty($cards);
    }

    public function testCanReturnASingleCard(): void
    {
        $card = $this->client->getCard('Luminaris');

        $this->assertIsArray($card);
        $this->assertSame('Luminaris', $card['name']);
    }
}
