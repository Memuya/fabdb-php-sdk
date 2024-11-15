# Flesh and Blood Card Library
A library to query and filter a list of cards and communicate with external APIs. Currently supports:
- FabDB [`\Memuya\Fab\Clients\FabDb\FabDbClient`] ([shutting down](https://rathetimes.com/articles/fab-db-shutting-down)).
- File [`\Memuya\Fab\Clients\File\FileClient`] (which can be used with the `cards.json` file located in this repository).

# Installation
This library can be installed via composer.

```
composer require memuya/fabdb-php-sdk
```

# Usage
This library is based on `Client` classes. Current, two different clients are supported.
  
Each `Client` has the following methods avaialble.

```php
/**
 * Return a filtered list of cards.
 *
 * @param array<string, mixed> $filters
 * @return mixed
 */
public function getCards(array $filters = []): mixed;

/**
 * Return information on a card.
 *
 * @param string $identifier
 * @return mixed
 */
public function getCard(string $identifier): mixed;

/**
 * Return information on the given deck.
 *
 * @param string $slug
 * @return mixed
 */
public function getDeck(string $slug): mixed;
```

# File Client
Use this to search for a card from a given JSON file. There is a `cards.json` file ready to go in this repository if you do not have your own.

```php
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Clients\FileClient;

$client = new FileClient('/path/to/this/repo/cards.json');
```

Once you're pointing to the JSON file, you're ready to start out of the box.

```php
// Search the file for all cards with a cost of '1' and a pitch of '1'.
$client->getCards([
    'cost' => '1',
    'pitch' => Pitch::One,
]);

// Search for a single card by its name/identifier.
$client->getCard('Luminaris');

// No deck support for file. Always returns [].
$client->getDeck('_');
```

## Filtering
Out of the box, when using the provided JSON file, a bunch of filters have already been created and registered for you by default. These include:
- CostFilter
- NameFilter
- PitchFilter
- PowerFilter
- SetNumberFilter

If you would like to filter/query the JSON file for something not already registered you can create and register your own filter and config classes. `Config` classes act as way to transfer data is an organised and type-hinted manner to the `Client`.

If you're looking to extend the config that is already present in this library, then feel free to extend the relevant classes. In our example, we're going to make it possible to query the `power` and `defence` properties for each card in the JSON file.

Here's an example extending `CardsConfig`. This will allow the new config to be used with `FileClient::getCards()`.

```php
namespace Some\Namespace;

use Memuya\Fab\Clients\File\Endpoints\Cards\CardsConfig;

class ExtendedCardsConfig extends CardsConfig
{
    #[Parameter]
    public string $power;

    #[Parameter]
    public string $defence;
}
```

If you want to create an entirely new `Config`, you can also do so. In the example below, you will only be able to filter by power/defence (with the relevant filter classes).
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\File\Endpoints\Card\CardConfig;

class MyCustomConfig extends Config
{
    #[Parameter]
    public string $power;

    #[Parameter]
    public string $defence;
}
```

Now we'll create a new filter for both `power` and `defence` that will filter for cards that have a power or defence <= the value passed, respectfully.

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

__Defence__
```php
namespace Some\Namespace;

use Memuya\Fab\Clients\File\Filters\Filterable;

class DefenceGteFilter implements Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['defence']) && ! is_null($filters['defence']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return (int) $card['defence'] >= (int) $filters['defence'];
        });
    }
}
```

We can then register these filters and configs to the relevant areas so that the client can start using them.

```php
use Some\Namespace\PowerGteFilter;
use Some\Namespace\DefenceGteFilter;
use Memuya\Fab\Clients\File\CardType;
use Some\Namespace\ExtendedCardConfig;
use Some\Namespace\ExtendedCardsConfig;

// Append to the already registered filters.
$client->registerFilters([
    new PowerGteFilter(),
    new DefenceGteFilter(),
]);

// Or if you want to completely override all registered filters, you can pass the filters into the constructor to start fresh.
$client = new FileClient(
    filepath: '/path/to/this/repo/cards.json',
    filters: [
        new PowerGteFilter(),
        new DefenceGteFilter(),
    ],
);

// FileClient::getCards() will now use ExtendedCardsConfig to see what it can query.
$client->registerConfig(CardType::Cards, ExtendedCardsConfig::class);

// You can also register config for FileClient::getCard() if you need to.
// Note that this will always search on 'name'.
$client->registerConfig(CardType::Card, SomeCardConfig::class);

// Now you can query/filter the card list.
$cards = $client->getCards([
    'power' => '2',
    'defence' => '3',
]);
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