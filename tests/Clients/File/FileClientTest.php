<?php

use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;

final class FileClientTest extends TestCase
{
    private string $cardsJsonFilePath;
    private string $testCardsJsonFilePath;
    private FileClient $client;

    public function setUp(): void
    {
        $this->cardsJsonFilePath = sprintf('%s/cards.json', dirname(__DIR__, 3));
        $this->testCardsJsonFilePath = sprintf('%s/test_cards.json', dirname(__DIR__, 2));

        $this->client = new FileClient($this->cardsJsonFilePath);
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

    public function testCanFilterFileWithCustomFilterAndConfigViaConstructor(): void
    {
        $client = new FileClient(
            filepath: $this->testCardsJsonFilePath,
            filters: [new IdentifierFilter()],
        );

        $cards = $client->filterList(
            new TestConfig(['identifier' => 'first'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterConfigDirectlyToFilterListWithCustomFilter(): void
    {
        $client = new FileClient($this->testCardsJsonFilePath);
        $client->registerFilters([new IdentifierFilter()]);

        $cards = $client->filterList(
            new TestConfig(['identifier' => 'first'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterDifferentConfigForCardsEndpoint(): void
    {
        $client = new FileClient($this->testCardsJsonFilePath);
        $client->registerFilters([new IdentifierFilter()]);
        $client->registerConfig(ConfigType::MultiCard, TestConfig::class);

        $cards = $client->getCards(['identifier' => 'first']);

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterDifferentConfigForCardEndpoint(): void
    {
        $client = new FileClient($this->testCardsJsonFilePath);
        $client->registerFilters([new IdentifierFilter()]);
        $client->registerConfig(ConfigType::SingleCard, TestConfig::class);

        $cards = $client->getCard('first');

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }
}

class TestConfig extends \Memuya\Fab\Clients\Config
{
    #[\Memuya\Fab\Attributes\Parameter]
    public string $identifier;
}

class IdentifierFilter implements \Memuya\Fab\Clients\File\Filters\Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['identifier']) && ! is_null($filters['identifier']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return str_contains($card['identifier'], $filters['identifier']);
        });
    }
}
