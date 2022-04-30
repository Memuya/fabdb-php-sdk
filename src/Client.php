<?php

namespace Memuya\Fab;

use stdClass;
use Throwable;
use Memuya\Fab\Endpoints\Endpoint;
use Memuya\Fab\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Endpoints\Deck\Deck as DeckEndpoint;
use Memuya\Fab\Endpoints\Cards\Cards as CardsEndpoint;
use Memuya\Fab\Exceptions\ResponseFormatNotSupportedException;

class Client
{
    /**
     * The URL of the API.
     * 
     * @param string
     */
    const BASE_URL = 'https://api.fabdb.net';

    /**
     * JSON response format option.
     * 
     * @param string
     */
    const RESPONSE_FORMAT_JSON = 'application/json';

    /**
     * XML response format option.
     * 
     * @param string
     */
    const RESPONSE_FORMAT_XML = 'application/xml';

    /**
     * CSV response format option.
     * 
     * @param string
     */
    const RESPONSE_FORMAT_CSV = 'text/csv';

    /**
     * Supported response formats.
     * 
     * @param array
     */
    const RESPONSE_FORMATS = [
        self::RESPONSE_FORMAT_JSON,
        self::RESPONSE_FORMAT_XML,
        self::RESPONSE_FORMAT_CSV,
    ];
    
    /**
     * The format of the API response.
     *
     * @var string
     */
    private string $responseFormat = self::RESPONSE_FORMAT_JSON;

    /**
     * Send off the request to the given route and return the response.
     *
     * @param Endpoint $endpoint
     * @return stdClass
     */
    public function sendRequest(Endpoint $endpoint): stdClass
    {
        $ch = curl_init(self::BASE_URL.$endpoint->getRoute());

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: {$this->responseFormat}",
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Set the format of the API response.
     *
     * @param string $response_format
     * @throws ResponseFormatNotSupportedException
     * @return void
     */
    public function setResponseFormat(string $response_format): void
    {
        if (! in_array($response_format, self::RESPONSE_FORMATS)) {
            throw new ResponseFormatNotSupportedException(sprintf('"%s" is not a supported response format', $response_format));
        }

        $this->responseFormat = $response_format;
    }

    /**
     * Return the currently set response format.
     *
     * @return string
     */
    public function getResponseFormat(): string
    {
        return $this->responseFormat;
    }
}