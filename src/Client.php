<?php

namespace Memuya\Fab;

use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Formatters\JsonFormatter;
use Memuya\Fab\Formatters\Formatter;

class Client
{
    /**
     * The URL of the API.
     * 
     * @param string
     */
    const BASE_URL = 'https://api.fabdb.net';

    /**
     * Determines if the response should be returned raw, without any transformation.
     *
     * @var bool
     */
    private bool $rawResponse = false;

    /**
     * @var Formatter|null
     */
    private Formatter $formatter;

    /**
     * @param Formatter $formatter
     */
    public function __construct(Formatter $formatter = new JsonFormatter)
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
}