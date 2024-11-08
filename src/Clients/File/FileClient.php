<?php

namespace Memuya\Fab\Clients\File;

use Memuya\Fab\ApiClient;
use Memuya\Fab\Clients\File\Filters\NameFilter;
use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Clients\File\Filters\Filterable;
use Memuya\Fab\Clients\File\Filters\PitchFilter;

class FileClient implements ApiClient
{
    /**
     * A list of all filters that can be applied.
     *
     * @var array<Filterable>
     */
    private array $filters = [];

    public function __construct()
    {
        $this->filters = [
            new NameFilter(),
            new PitchFilter(),
        ];
    }

    /**
     * Send off the request to the given route and return the response.
     *
     * @param Endpoint $endpoint
     * @return mixed
     */
    public function sendRequest(Endpoint $endpoint): array
    {
        $cards = json_decode(file_get_contents($endpoint->getRoute()), true);
        $filters = $endpoint->getConfig()->toArray();

        foreach ($this->filters as $filter) {
            if ($filter->canResolve($filters)) {
                $cards = $filter->applyTo($cards, $filters);
            }
        }

        return $cards;
    }
}
