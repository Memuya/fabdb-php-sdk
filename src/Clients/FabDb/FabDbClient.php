<?php

namespace Memuya\Fab\Clients\FabDb;

use Memuya\Fab\Clients\ApiClient;
use Memuya\Fab\Clients\Endpoint;
use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Clients\FabDb\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Cards\CardsEndpoint;
use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckEndpoint;
use Memuya\Fab\Clients\FabDb\Formatters\Formatter;
use Memuya\Fab\Clients\FabDb\Formatters\JsonFormatter;
use stdClass;

class FabDbClient implements ApiClient
{
    /**
     * The URL of the API.
     *
     * @param string
     */
    public const BASE_URL = 'https://api.fabdb.net';

    /**
     * Determines if the response should be returned raw, without any transformation.
     *
     * @var bool
     */
    private bool $rawResponse = false;

    /**
     * @var Formatter
     */
    private Formatter $formatter;

    /**
     * @param Formatter $formatter
     */
    public function __construct(Formatter $formatter = new JsonFormatter())
    {
        $this->formatter = $formatter;
    }

    /**
     * Send off the request to the given route and return the response.
     *
     * @param Endpoint $endpoint
     * @return mixed
     */
    public function sendRequest(Endpoint $endpoint): mixed
    {
        $ch = curl_init(sprintf('%s%s', self::BASE_URL, $endpoint->getRoute()));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $endpoint->getHttpMethod()->name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: {$this->formatter->getContentType()}",
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return $this->transformResponse($response);
    }

    /**
     * Format the response to the selected response format.
     *
     * @param string $response
     * @return mixed
     */
    public function transformResponse(string $response): mixed
    {
        if ($this->rawResponse) {
            return $response;
        }

        return $this->formatter->format($response);
    }

    /**
     * Set the formatter.
     *
     * @param Formatter $formatter
     * @return void
     */
    public function setFormatter(Formatter $formatter): void
    {
        $this->formatter = $formatter;
    }

    /**
     * Return the current formatter.
     *
     * @return Formatter
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter;
    }

    /**
     * Set whether the API response will be returned raw or not.
     *
     * @param bool $value
     * @return self
     */
    public function shouldReturnRaw(bool $value = true): self
    {
        $this->rawResponse = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCards(array $filters): stdClass
    {
        return $this->sendRequest(
            new CardsEndpoint(
                new CardsConfig($filters)
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function getCard(string $identifier): stdClass
    {
        return $this->sendRequest(
            new CardEndpoint(
                new CardConfig(['identifier' => $identifier])
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function getDeck(string $slug): stdClass
    {
        return $this->sendRequest(
            new DeckEndpoint(
                new DeckConfig(['slug' => $slug])
            )
        );
    }
}