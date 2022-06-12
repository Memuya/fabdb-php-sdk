<?php

namespace Memuya\Fab\Endpoints\Cards;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Endpoints\BaseConfig;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

class CardsConfig extends BaseConfig
{
    const PER_PAGE_MAX = 100;

    const PITCH_OPTIONS = [
        '1',
        '2',
        '3',
        '4+',
    ];

    const CLASS_OPTIONS = [
        'brute',
        'guardian',
        'illusionist',
        'mechanologist',
        'merchant',
        'ninja',
        'ranger',
        'runeblade',
        'shapeshifter',
        'warrior',
        'wizard',
    ];

    const RARITY_OPTIONS = [
        'C',
        'R',
        'S',
        'T',
        'L',
        'F',
        'P',
    ];

    const SET_OPTIONS = [
        'WTR',
        'ARC',
        'CRU',
        'MON',
        'EVR',
    ];

    /**
     * Page number.
     *
     * @var int
     */
    public int $page = 1;

    /**
     * Keyword to search with
     *
     * @var string
     */
    public string $keywords;

    /**
     * Amount of records to display with each request.
     *
     * @var int
     */
    public int $per_page;

    /**
     * The pitch count to filter by.
     *
     * @var string
     */
    public string $pitch;

    /**
     * The class to filter by.
     *
     * @var string
     */
    public string $class;

    /**
     * The cost to filter by.
     *
     * @var string
     */
    public string $cost;

    /**
     * The rarity to filter by.
     *
     * @var string
     */
    public string $rarity;

    /**
     * The set to filter by.
     *
     * @var string
     */
    public string $set;

    /**
     * Convert the config into a usable query string.
     *
     * @return string
     */
    public function toQueryString(): string
    {
        $reflection = new ReflectionClass($this);
        $query_string_array = [];

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $property_name = $property->getName();

            if (! isset($this->{$property_name})) {
                continue;
            }

            $query_string_array[$property_name] = $this->{$property_name};
        }

        return http_build_query($query_string_array);
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function setPerPage(int $per_page): void
    {
        if ($per_page > self::PER_PAGE_MAX) {
            throw new InvalidCardConfigException(sprintf('per_page cannot be greater than %s', self::PER_PAGE_MAX));
        }

        $this->per_page = $per_page;
    }

    public function setPitch(string $pitch): void
    {
        if (! in_array($pitch, self::PITCH_OPTIONS)) {
            throw new InvalidCardConfigException('Unknown pitch value');
        }

        $this->pitch = $pitch;
    }

    public function setClass(string $class): void
    {
        if (! in_array($class, self::CLASS_OPTIONS)) {
            throw new InvalidCardConfigException('Unknown class value');
        }

        $this->class = $class;
    }

    public function setCost(string $cost): void
    {
        $this->cost = $cost;
    }

    public function setRarity(string $rarity): void
    {
        if (! in_array($rarity, self::RARITY_OPTIONS)) {
            throw new InvalidCardConfigException('Unknown rarity value');
        }

        $this->rarity = $rarity;
    }

    public function setSet(string $set): void
    {
        if (! in_array($set, self::SET_OPTIONS)) {
            throw new InvalidCardConfigException('Unknown set value');
        }

        $this->set = $set;
    }

    public function __toString()
    {
        return $this->toQueryString();
    }
}