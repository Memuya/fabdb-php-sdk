<?php

namespace Memuya\Fab\Clients\File;

use ReflectionClass;
use RuntimeException;
use SplObjectStorage;
use Memuya\Fab\Clients\Client;
use Memuya\Fab\Clients\Config;
use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Exceptions\ConfigNotRegisteredException;

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
     * The registered config classes for each config type.
     * Example:
     * [
     *     ConfigType::MultiCard => CardsConfig::class,
     *     ConfigType::SingleCard => CardConfig::class,
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
        $this->registeredConfig = new SplObjectStorage();

        $this->registerFilters($filters);
    }

    /**
     * Append to the existing list of filters.
     *
     * @param array<Filterable> $filters
     * @return void
     */
    public function registerFilters(array $filters): void
    {
        $filters = array_filter(
            $filters,
            fn($filter): bool => $filter instanceof Filterable,
        );

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
            $this->resolveConfig(ConfigType::MultiCard, $filters),
        );
    }

    /**
     * @inheritDoc
     */
    public function getCard(string $identifier, string $key = 'name'): array
    {
        return $this->filterList(
            $this->resolveConfig(ConfigType::SingleCard, [$key => $identifier]),
        )[0] ?? [];
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
     * @throws RuntimeException
     */
    private function readFileToJson(): array
    {
        if (! file_exists($this->filepath)) {
            throw new RuntimeException('File not found.');
        }

        return json_decode(file_get_contents($this->filepath), true);
    }

    /**
     * Check to see if the given config type has been registered.
     *
     * @param ConfigType $type
     * @return bool
     */
    private function isConfigRegisteredFor(ConfigType $type): bool
    {
        return isset($this->registeredConfig[$type]);
    }

    /**
     * Resolve the config object needed for the given type.
     *
     * @param ConfigType $type
     * @param array<string, mixed> $filters
     * @return Config
     * @throws ConfigNotRegisteredException
     */
    private function resolveConfig(ConfigType $type, array $filters): Config
    {
        if (! $this->isConfigRegisteredFor($type)) {
            throw new ConfigNotRegisteredException("Config not registerd for {$type->name}.");
        }

        $reflection = new ReflectionClass($this->registeredConfig[$type]);

        return $reflection->newInstance($filters);
    }
}
