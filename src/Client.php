<?php

namespace Memuya\Fab;

use Memuya\Fab\Endpoints\Config;
use Memuya\Fab\Enums\HttpMethod;
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
    public const BASE_URL = 'https://api.fabdb.net';

    /**
     * Hashing algorithm used in the request.
     *
     * @var string
     */
    public const HASHING_ALGORITHM = 'sha512';

    /**
     * Determines if the response should be returned raw, without any transformation.
     *
     * @var bool
     */
    private bool $rawResponse = false;

    /**
     * The API token provided by fabdb.net.
     *
     * @link https://fabdb.net/resources/api
     * @var string
     */
    private string $token;

    /**
     * The API secret provided by fabdb.net.
     *
     * @link https://fabdb.net/resources/api
     * @var string
     */
    private string $secret;

    /**
     * @var Formatter
     */
    private Formatter $formatter;

    /**
     * @param string $token
     * @param string $secret
     * @param Formatter $formatter
     */
    public function __construct(string $token, string $secret, Formatter $formatter = new JsonFormatter())
    {
        $this->token = $token;
        $this->secret = $secret;
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
        $ch = curl_init($this->generateEndpointUrl($endpoint));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $endpoint->getHttpMethod()->name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: {$this->formatter->getContentType()->value}",
            "Authorization: Bearer {$this->token}",
        ]);

        if ($endpoint->getHttpMethod() !== HttpMethod::GET) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $endpoint->getConfig()->getRequestBodyValues());
        }

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
    private function transformResponse(string $response): mixed
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
     * Set to 'true' if you want to ignore the formatter and return the API response raw.
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
            $this->buildHashedQueryString($endpoint->getConfig())
        );
    }

    /**
     * Build up the query string and hash it.
     *
     * @param Config $config
     * @return string
     */
    private function buildHashedQueryString(Config $config): string
    {
        return http_build_query([
            'time' => $config->time,
            'hash' => $this->hashQueryString($this->buildQueryString($config)),
        ]);
    }

    /**
     * Hash the query string.
     *
     * @param string $queryString
     * @return string
     */
    private function hashQueryString(string $queryString): string
    {
        return hash(self::HASHING_ALGORITHM, $queryString);
    }

    /**
     * Build the query string.
     *
     * @param Config $config
     * @return string
     */
    private function buildQueryString(Config $config): string
    {
        return sprintf(
            '%s%s',
            $this->secret,
            http_build_query($config->getQueryStringValues())
        );
    }
}
