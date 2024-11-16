<?php

use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;

final class FileClientTest extends TestCase
{
    private string $testCardsJsonFilePath;
    private FileClient $client;

    public function setUp(): void
    {
        $this->testCardsJsonFilePath = sprintf('%s/test_cards.json', dirname(__DIR__, 2));

        $this->client = new FileClient($this->testCardsJsonFilePath, [new FileClientTestIdentifierFilter()]);
        $this->client->registerConfig(ConfigType::MultiCard, FileClientTestCardsConfig::class);
        $this->client->registerConfig(ConfigType::SingleCard, FileClientTestCardConfig::class);
    }

    public function testCanReadFromJsonFile(): void
    {
        $cards = $this->client->getCards();

        $this->assertNotEmpty($cards);
    }

    public function testCanFilterResults(): void
    {
        $cards = $this->client->getCards([
            'identifier' => 'first',
        ]);

        $this->assertNotEmpty($cards);
        $this->assertCount(1, $cards);
        $this->assertSame('first', $cards[0]['identifier']);
    }

    public function testResultIsEmptyWhenFiltersDoNotMatchACard(): void
    {
        $cards = $this->client->getCards([
            'identifier' => 'does_not_exist',
        ]);

        $this->assertEmpty($cards);
    }

    public function testCanReturnASingleCard(): void
    {
        $card = $this->client->getCard('second', 'identifier');

        $this->assertIsArray($card);
        $this->assertSame('second', $card['identifier']);
    }

    public function testCanFilterFileWithCustomFilterAndConfigViaConstructor(): void
    {
        $this->client->registerFilters([new FileClientTestCostFilter()]);

        $cards = $this->client->filterList(
            new TestConfig(['cost' => '1'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterConfigDirectlyToFilterListWithCustomFilter(): void
    {
        $this->client->registerFilters([new FileClientTestCostFilter()]);

        $cards = $this->client->filterList(
            new TestConfig(['cost' => '2'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterDifferentConfigForCardsEndpoint(): void
    {
        $this->client->registerFilters([new FileClientTestCostFilter()]);
        $this->client->registerConfig(ConfigType::MultiCard, TestConfig::class);

        $cards = $this->client->getCards(['cost' => '1']);

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterDifferentConfigForCardEndpoint(): void
    {
        $this->client->registerFilters([new FileClientTestCostFilter()]);
        $this->client->registerConfig(ConfigType::SingleCard, TestConfig::class);

        $card = $this->client->getCard('1', 'cost');

        $this->assertIsArray($card);
        $this->assertSame('1', $card['cost']);
    }
}

class FileClientTestCardsConfig extends \Memuya\Fab\Clients\Config
{
    #[\Memuya\Fab\Attributes\Parameter]
    public string $identifier;
}

class FileClientTestCardConfig extends \Memuya\Fab\Clients\Config
{
    #[\Memuya\Fab\Attributes\Parameter]
    public string $identifier;
}

class TestConfig extends \Memuya\Fab\Clients\Config
{
    #[\Memuya\Fab\Attributes\Parameter]
    public string $identifier;

    #[\Memuya\Fab\Attributes\Parameter]
    public string $cost;
}

class FileClientTestIdentifierFilter implements \Memuya\Fab\Clients\File\Filters\Filterable
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

class FileClientTestCostFilter implements \Memuya\Fab\Clients\File\Filters\Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['cost']) && ! is_null($filters['cost']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return str_contains($card['cost'], $filters['cost']);
        });
    }
}
