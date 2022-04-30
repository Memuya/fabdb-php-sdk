
# Flesh and Blood ([fabdb.net](https://fabdb.net/resources/api)) API library
A library to communicate with the [fabdb.net](https://fabdb.net/resources/api) API.

# Installation
This library can be installed via composer.

```
composer require memuya/fabdb-php-sdk
```

# Usage
A new instance can be created by creating a `Client` object.

```php
use Memuya\Fab\Client;

$client = new Client;
```

## Response Format
You can change the response format to one of the following. By default, `Client::RESPONSE_FORMAT_JSON` is used.

**Please note** that the API does not seem to honor this parameter so all responses are currently returned as `JSON`.

```php
// This method can take one of the following:
// Client::RESPONSE_FORMAT_JSON
// Client::RESPONSE_FORMAT_XML
// Client::RESPONSE_FORMAT_CSV
$client->setResponseFormat(Client::RESPONSE_FORMAT_JSON);
```

    

## List of Cards
Returns a paginated list of cards. The list of cards can be filtered down using the `CardsConfig` object. See below example for all filtering options. All filtering options are **optional**. If a filter is not valid, an `InvalidCardConfigException` exception in thrown.
For a full list of options please see the API [documentation](https://fabdb.net/resources/api).

```php
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Endpoints\Cards\CardsEndpoint;

try {
    $cards = $client->sendRequest(
        new CardsEndpoint(
            new CardsConfig([
                'page' => 1,
                'per_page' => 10,
                'keywords' => 'search terms',
                'pitch' => '3',
                'cost' => '1',
                'class' => 'brute',
                'rarity' => 'C',
                'set' => 'WTR',
            ])
        )
    );
} catch (\Memuya\Fab\Exceptions\InvalidCardConfigException $ex) {
    // Handle exception...
}
```

## Return a Card
Search for a card using its identifier.

```php
use Memuya\Fab\Endpoints\Card\CardConfig;
use Memuya\Fab\Endpoints\Card\CardEndpoint;

$client->sendRequest(
    new CardEndpoint(
        new CardConfig(['identifier' => 'ARC000'])
    )
);
```

## Decks
Return information on a given deck.

```php
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;

$client->sendRequest(
    new DeckEndpoint(
        new DeckConfig(['slug' => 'deck-slug'])
    )
);
```