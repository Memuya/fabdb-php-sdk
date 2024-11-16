<?php

namespace Memuya\Fab\Clients\TheFabCube;

use Memuya\Fab\Clients\Client;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Clients\TheFabCube\Filters\CostFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\NameFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\TypeFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PitchFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PowerFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\SetNumberFilter;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Cards\CardsConfig;

class TheFabCubeClient implements Client
{
    private FileClient $fileClient;

    /**
     * @param string $filepath
     * @param array<Filterable> $filters
     */
    public function __construct(string $filepath, array $filters = [])
    {
        $this->fileClient = new FileClient(
            $filepath,
            $filters ?: [
                new NameFilter(),
                new PitchFilter(),
                new CostFilter(),
                new SetNumberFilter(),
                new PowerFilter(),
                new TypeFilter(),
            ],
        );
        $this->fileClient->registerConfig(ConfigType::MultiCard, CardsConfig::class);
        $this->fileClient->registerConfig(ConfigType::SingleCard, CardConfig::class);
    }

    /**
     * @inheritDoc
     */
    public function getCards(array $filters = []): array
    {
        return $this->fileClient->getCards($filters);
    }

    /**
     * @inheritDoc
     */
    public function getCard(string $identifier, string $key = 'name'): array
    {
        return $this->fileClient->getCard($identifier, $key);
    }

    /**
     * @inheritDoc
     */
    public function getDeck(string $slug): array
    {
        return [];
    }

    public function getFileClient(): FileClient
    {
        return $this->fileClient;
    }
}
