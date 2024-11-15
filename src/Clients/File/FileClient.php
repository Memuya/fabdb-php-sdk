<?php

namespace Memuya\Fab\Clients\File;

use ReflectionClass;
use SplObjectStorage;
use Memuya\Fab\Clients\Client;
use Memuya\Fab\Clients\Config;
use Memuya\Fab\Clients\File\Filters\CostFilter;
use Memuya\Fab\Clients\File\Filters\NameFilter;
use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\File\Filters\PitchFilter;
use Memuya\Fab\Clients\File\Filters\SetNumberFilter;
use Memuya\Fab\Clients\File\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\File\Endpoints\Cards\CardsConfig;

class FileClient implements Client
{
    /**
     * The location of the JSON file.
     *
     * @var string
     */
    private string $filepath;

    /**
     * A list of all filters that can be applied.
     *
     * @var array<Filterable>
     */
    private array $filters = [];

    /**
     * The registered config classes for each request.
     * Example:
     * [
     *     ConfigType::Cards => CardsConfig::class,
     *     ConfigType::Card => CardConfig::class,
     * ]
     *
     * @var SplObjectStorage<ConfigType, class-string>
     */
    private SplObjectStorage $registeredConfig;

    /**
     * @param string $filepath
     * @param array<Filterable> $filters
     */
    public function __construct(string $filepath, array $filters = [])
    {
        $this->filepath = $filepath;
        $this->filters = $filters ?: [
            new NameFilter(),
            new PitchFilter(),
            new CostFilter(),
            new SetNumberFilter(),
        ];

        $this->registeredConfig = new SplObjectStorage();
        $this->registeredConfig[ConfigType::Cards] = CardsConfig::class;
        $this->registeredConfig[ConfigType::Card] = CardConfig::class;
    }

    /**
     * Register filters can are usable when querying from the file.
     *
     * @param array<Filterable> $filters
     * @return void
     */
    public function registerFilters(array $filters): void
    {
        $this->filters = array_merge($this->filters, $filters);
    }

    /**
     * Register the config
     *
     * @param ConfigType $type
     * @param class-string $config
     * @return void
     */
    public function registerConfig(ConfigType $type, string $config): void
    {
        $this->registeredConfig[$type] = $config;
    }

    /**
     * @inheritDoc
     */
    public function getCards(array $filters = []): array
    {
        return $this->filterList(
            $this->resolveConfig(ConfigType::Cards, $filters)
        );
    }

    /**
     * @inheritDoc
     */
    public function getCard(string $identifier): array
    {
        return $this->filterList(
            $this->resolveConfig(ConfigType::Card, ['name' => $identifier])
        )[0] ?? [];
    }

    /**
     * @inheritDoc
     */
    public function getDeck(string $slug): array
    {
        return [];
    }

    /**
     * Read and filter cards from the registered JSON file.
     *
     * @param Config $config
     * @return array<string, mixed>
     */
    public function filterList(Config $config): array
    {
        $cards = $this->readFileToJson();
        $filters = $config->getParameterValues();

        /** @var Filterable $filter */
        foreach ($this->filters as $filter) {
            if ($filter->canResolve($filters)) {
                $cards = $filter->applyTo($cards, $filters);
            }
        }

        // Reset array keys.
        return array_values($cards);
    }

    /**
     * Read the file into a local JSON array.
     *
     * @return array<string, mixed>
     */
    private function readFileToJson(): array
    {
        return json_decode(file_get_contents($this->filepath), true);
    }

    /**
     * Resolve the config object needed for the given type.
     *
     * @param ConfigType $type
     * @param array<string, mixed> $filters
     * @return Config
     */
    private function resolveConfig(ConfigType $type, array $filters): Config
    {
        $reflection = new ReflectionClass($this->registeredConfig[$type]);

        return $reflection->newInstance($filters);
    }
}
