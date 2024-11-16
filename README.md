# Flesh and Blood Card Library
A library to query and filter a list of cards and communicate with external APIs.

## FabDB
> ⚠️ Notice -> [https://fabdb.net](https://fabdb.net) is [shutting down](https://rathetimes.com/articles/fab-db-shutting-down). This client is no longer usable and will be removed.

## File
Can read and filter from a provided JSON file.

## The FAB Cube
An excerpt from their [Git repo](https://github.com/the-fab-cube/flesh-and-blood-cards).
> This repo is intended as a comprehensive, open-source resource for representing all cards and sets from the Flesh and Blood TCG as JSON and CSV files.

# Installation
This library can be installed via composer.

```
composer require memuya/fabdb-php-sdk
```

# Usage
This library is based on `Client` classes. Current, two different clients are supported.

# The FAB Cube
As mentioned previously, The FAB Cube is a repository that stores an up-to-date list of all Flesh and blood cards. To start using this client, you will need to download `card.json` from their [Git repo](https://github.com/the-fab-cube/flesh-and-blood-cards/tree/develop/json).

Here's the link to the raw JSON for english printed cards.
```
https://raw.githubusercontent.com/the-fab-cube/flesh-and-blood-cards/refs/heads/develop/json/english/card.json
```

To get start, firstly you will need to create a new client.
```php
use Memuya\Fab\Clients\TheFabCube\TheFabCubeClient;

$client = new TheFabCubeClient('/path/to/card.json');
```

## Single Card
To retrieve a single card by name, you can use the `getCard()` method.
```php
/** @var \Memuya\Fab\Clients\TheFabCube\Entities\Card $card */
$card = $client->getCard('Luminaris');

// Optionally, you may specify a key to search as the second argument. By default, it will use the 'name' key.
// For example, for whatever reason, you can filter the list by `cost = 1` and return the first result.
$card = $client->getCard('1', 'cost');
```

## Card List
To retrieve a list of cards, you can use the `getCards()` method. When you pass no filters to this method it will return all cards stored in the JSON file.
```php
/** @var array<\Memuya\Fab\Clients\TheFabCube\Entities\Card> $cards */
$cards = $client->getCards();
```

## Filtering
Filters are used to tell the client how we want to filter down the list of cards. Out of the box, a bunch of filters have already been created and registered for you by default.
| Filter    | Type | Description |
| -------- | ------- | ------- |
| CostFilter  | string | Checks for exact match on the `cost` field.    |
| NameFilter | string | Checks for a wild card match on the `name` field.     |
| PitchFilter    | string | Checks for exact match on the `pitch` field.    |
| PowerFilter  | string | Checks for exact match on the `power` field.    |
| SetNumberFilter | string | Checks for exact match on the `printings.set_id` field.     |
| TypeFilter    | array\<string> | Checks for the inclusion of a type on the `types` field.    |

```php
// Get all cards that:
// - Cost 1 to play.
// - Pitch for 1.
// - Have an attack power of 3.
$cards = $client->getCards([
    'cost' => '2',
    'pitch' => '3',
    'power' => '3',
]);
```

To register custom filters, please see the [File Client](#file-client) section below.

If you would like to filter/query the JSON file for something not already registered you can create and register your own filter and config classes. `Config` classes act as way to transfer data is an organised and type-hinted manner to the `Client`.

If you're looking to extend the config that is already present in this library, then feel free to extend the relevant classes. In our example, we're going to make it possible to query the `power` property for each card in the JSON file.

Here's an example extending `CardsConfig`. This will allow the new config to be used with `TheFabCubeClient::getCards()`.

```php
namespace Some\Namespace;

use Memuya\Fab\Clients\TheFabCube\Endpoints\Cards\CardsConfig;

class ExtendedCardsConfig extends CardsConfig
{
    #[Parameter]
    public string $power;
}
```

If you want to create an entirely new `Config`, you can also do so. In the example below, you will only be able to filter by power (with the relevant filter classes).
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\TheFabCube\Endpoints\Card\CardConfig;

class MyCustomConfig extends CardConfig
{
    #[Parameter]
    public string $power;
}
```

Now we'll create a new filter for `power` that will filter for cards that have a power <= than the value passed.

__Power__
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\File\Filters\Filterable;

class PowerGteFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        // The $filters array is generated from the associated `Config` class' `Parameter` proerties.
        // If a filter is not defined in the associated `Config` class it will not be available.
        return isset($filters['power']) && ! is_null($filters['power']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return (int) $card['power'] >= (int) $filters['power'];
        });
    }
}
```

We can then register this filter and configs to the relevant areas so that the client can start using them. This is done by updating the underlaying `FileClient` object.

```php
use Some\Namespace\PowerGteFilter;
use Some\Namespace\ExtendedCardConfig;
use Some\Namespace\ExtendedCardsConfig;
use Memuya\Fab\Clients\File\ConfigType;

// Append to the already registered filters.
$client->getFileClient()
    ->registerFilters([new PowerGteFilter()]);

// Or if you want to completely override all registered filters, you can pass the filters into the constructor to start fresh.
$client = new TheFabCubeClient(
    filepath: '/path/to/card.json',
    filters: [new PowerGteFilter()],
);

// TheFabCubeClient::getCards() will now use ExtendedCardsConfig to determine what parameters it can query.
$client->getFileClient()
    ->registerConfig(ConfigType::MultiCard, ExtendedCardsConfig::class);

// You can also register config for TheFabCubeClient::getCard() if you need to.
$client->getFileClient()
    ->registerConfig(ConfigType::SingleCard, SomeCardConfig::class);

// Now you can query/filter the card list.
$cards = $client->getCards([
    'power' => '2',
]);
```

# File Client
Use this to search from a given JSON file.

This client is used as the underlaying logic for the `TheFabCubeClient` class but can also be used for any other JSON file.

```php
use Memuya\Fab\Clients\FileClient;

$client = new FileClient('/path/to/card.json');
```

For our examples below, we'll assume this is the contents of the `/path/to/cards.json` file.
```json
[
    {
        "name": "first",
        "cost": "1"
    },
    {
        "name": "second",
        "cost": "2"
    }
]
```

## Register `Config` Classes
Firstly, you'll need a `Config` class for each type of config that is currently allowed. `Config` classes act as way to transfer data is an organised and type-hinted manner to the `Client`. You'll need one for both `MultiCard` and `SingleCard` config.

Here's an example `Config` class that we'll register to `MultiCard`.
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\Config;

class CardsConfig extends Config
{
    #[Parameter]
    public string $name;

    #[Parameter]
    public string $cost;
}
```

Here's an example `Config` class that we'll register to `SingleCard`.
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\Config;

class CardConfig extends Config
{
    #[Parameter]
    public string $name;

    #[Parameter]
    public string $cost;
}
```
We'll then need a filter for each parameter we want to be able to filter by. For simplicity, we'll make it so you can only filter by name.
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\File\Filters\Filterable;

class NameFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['name']) && ! is_null($filters['name']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return str_contains($card['name'], $filters['name']);
        });
    }
}
```

Now we can register both the `Config` classes and the filter to the `FileClient`.
```php
// Append to the already registered filters.
$client->registerFilters([
    new NameFilter(),
]);

// Or if you want to completely override all registered filters, you can pass the filters into the constructor to start fresh.
$client = new FileClient(
    filepath: '/path/to/card.json',
    filters: [
        new \Some\Namespace\NameFilter(),
    ],
);

// FileClient::getCards() will now use CardsConfig to see what it can query.
$client->registerConfig(ConfigType::MultiCard, \Some\Namespace\CardsConfig::class);

// FileClient::getCard() will now use CardConfig to see what it can query.
$client->registerConfig(ConfigType::SingleCard, \Some\Namespace\CardConfig::class);
```

That's it! You can now filter your JSON file by name.
```php
$cards = $client->getCards([
    'name' => 'first',
]);

echo $cards[0]['name']; // first

$card = $client->getCard('second');

echo $card['name']; // second
```

## Lower Level Control
If you want to do your own filtering without conforming with the `Client` interface, you can use `FileClient::filterList()` directly with any `Config` you wish.

```php
use Memuya\Fab\Clients\FileClient;

$client = new FileClient('/path/to/file.json');
$filteredListOfCardsFromFile = $client->filterList(
    new SomeOtherConfig([
        'some_field' => 'some_value',
    ])
);
```

# FabDB Client (deprecated)

> ⚠️ Notice -> [https://fabdb.net](https://fabdb.net) is [shutting down](https://rathetimes.com/articles/fab-db-shutting-down). This client is no longer usable and will be removed.

Use this to access the [FabDB API](https://fabdb.net/resources/api).

```php
use Memuya\Fab\Clients\FabDbClient;

$client = new FabDbClient();
```
## Formatter
You can change the response format by passing a `Formatter` to the client. By default, `JsonFormatter` is used. This is used to also populate the `Accept` request header.

**Please note** that the API does not seem to honor anything but JSON in the `Accept` header. This means only `JsonFormatter` should be used.

List of formatters:
```php
new \Memuya\Fab\Formatter\JsonFormatter; // Accept: application/json
new \Memuya\Fab\Formatter\XmlFormatter; // Accept: application/xml
new \Memuya\Fab\Formatter\CsvFormatter; // Accept: text/csv
```

You can use a formatter via the contructor or the setter method:
```php
// Via the contructor.
$client = new FabDbClient(new JsonFormatter);

// Via the setter.
$client->setFormatter(new JsonFormatter);
```

## List of Cards
Returns a paginated list of cards. The list of cards can be filtered down using the `CardsConfig` object. See below example for all filtering options. All filtering options are **optional**. If a filter is not valid, an `InvalidCardConfigException` exception in thrown.
For a full list of options please see the API [documentation](https://fabdb.net/resources/api).

```php
use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

try {
    $cards = $client->getCards([
        'page' => 1,
        'per_page' => 10,
        'keywords' => 'search terms',
        'cost' => '1',
        'pitch' => Pitch::One,
        'class' => HeroClass::Brute,
        'rarity' => Rarity::Common,
        'set' => Set::WelcomeToRathe,
    ]);
} catch (InvalidCardConfigException $ex) {
    // Handle exception...
}
```
## Return a Card
Search for a card using its identifier.

```php
$client->getCard('ARC000');
```

## Decks
Return information on a given deck.

```php
$client->sendRequest('deck-slug');
```