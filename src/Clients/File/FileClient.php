<?php

namespace Memuya\Fab\Clients\File;

use Memuya\Fab\Clients\ApiClient;
use Memuya\Fab\Clients\BaseConfig;
use Memuya\Fab\Clients\File\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\File\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\File\Filters\NameFilter;
use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\File\Filters\PitchFilter;

class FileClient implements ApiClient
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

    public function __construct(string $filepath, array $filters = [])
    {
        $this->filepath = $filepath;
        $this->filters = array_merge($filters, [
            new NameFilter(),
            new PitchFilter(),
        ]);
    }

    /**
     * Read and filter cards from the registered JSON file.
     *
     * @param BaseConfig $config
     * @return array<string, mixed>
     */
    public function readFromFile(BaseConfig $config): array
    {
        $cards = json_decode(file_get_contents($this->filepath), true);
        $filters = $config->onlyParameters();

        foreach ($this->filters as $filter) {
            if ($filter->canResolve($filters)) {
                $cards = $filter->applyTo($cards, $filters);
            }
        }

        // Reset array keys.
        return array_values($cards);
    }

    /**
     * @inheritDoc
     */
    public function getCards(array $filters): array
    {
        return $this->readFromFile(new CardsConfig($filters));
    }

    /**
     * @inheritDoc
     */
    public function getCard(string $identifier): array
    {
        return $this->readFromFile(new CardConfig(['name' => $identifier]))[0] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getDeck(string $slug): array
    {
        return [];
    }
}