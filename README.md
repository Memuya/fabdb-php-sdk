
# Flesh and Blood ([fabdb.net](https://fabdb.net/resources/api)) API library
A library to communicate with the [fabdb.net](https://fabdb.net/resources/api) API.
# Usage
A new instance can be created by creating a `Fab` object.

```php
use Memuya\Fab\Fab;

$fab = new Fab;
```

## Response Format
You can change the response format to one of the following. By default, `Fab::RESPONSE_FORMAT_JSON` is used.

```php
// This method can take one of the following:
// Fab::RESPONSE_FORMAT_JSON
// Fab::RESPONSE_FORMAT_XML
// Fab::RESPONSE_FORMAT_CSV
$fab->setResponseFormat(Fab::RESPONSE_FORMAT_JSON);
```

    

## List of Cards
Returns a paginated list of cards. The list of cards can be filtered down using the `CardsConfig` object. See below example for all filtering options. All filtering options are **optional**. If a filter is not valid, an `InvalidCardConfigException` exception in thrown.
For a full list of options please see the API [documentation](https://fabdb.net/resources/api).

```php
try {
    $cards = $fab->cards(
        new \Memuya\Fab\RequestConfig\CardsConfig([
            'page' => 1,
            'per_page' => 10,
            'keywords' => 'search terms',
            'pitch' => '3',
            'cost' => '1',
            'class' => 'brute',
            'rarity' => 'C',
            'set' => 'WTR',
        ])
    );
} catch (\Memuya\Fab\Exceptions\InvalidCardConfigException $ex) {
    // Handle exception...
}
```

## Return a Card
Search for a card using it's identifier.

```php
$fab->card('ARC000');
```

## Decks
Return information on a given deck.

```php
$fab->deck('deck-slug');
```