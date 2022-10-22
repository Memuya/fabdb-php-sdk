<?php

namespace Memuya\Fab;

use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Formatters\Formatter;
use Memuya\Fab\Formatters\JsonFormatter;

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
     * @var Formatter
     */
    private Formatter $formatter;

    /**
     * The API token provided by fabdb.net.
     *
     * @var string
     */
    private string $token;

    /**
     * The API secret provided by fabdb.net.
     *
     * @var string
     */
    private string $secret;

    /**
     * @param string $token Token generated from https://fabdb.net/resources/api
     * @param string $secret Secret generated from https://fabdb.net/resources/api
     * @param Formatter $formatter
     */
    public function __construct(string $token, string $secret, Formatter $formatter = new JsonFormatter)
    {
        $this->formatter = $formatter;
        $this->token = $token;
        $this->secret = $secret;
    }

    /**
     * Send off the request to the given route and return the response.
     *
     * @param Endpoint $endpoint
     * @return mixed
     */
    public function sendRequest(Endpoint $endpoint): mixed
    {
        $ch = curl_init($this->generateEndpointUrl($endpoint));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $endpoint->getHttpMethod()->name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: {$this->formatter->getContentType()}",
            "Authorization: Bearer {$this->token}",
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
     * Generate the final URL to be called.
     *
     * @param Endpoint $endpoint
     * @return string
     */
    private function generateEndpointUrl(Endpoint $endpoint): string
    {
        return sprintf(
            '%s%s?%s',
            self::BASE_URL,
            $endpoint->getRoute(),
            $this->buildQueryString($endpoint)
        );
    }

    /**
     * Generate the hash to be used in the query string by using sha512 on the secret and UNIX timestamp.
     *
     * @param Endpoint $endpoint
     * @return string
     */
    private function generateTimeHash(Endpoint $endpoint): string
    {
        return $this->secret.hash('sha512', $endpoint->getConfig()->time);
    }

    /**
     * Build the query string to use used with the API endpoint.
     *
     * @param Endpoint $endpoint
     * @return string
     */
    private function buildQueryString(Endpoint $endpoint): string
    {
        return http_build_query([
            ...$endpoint->getConfig()->getQueryAsArray(),
            'hash' => $this->generateTimeHash($endpoint)
        ]);
    }
}