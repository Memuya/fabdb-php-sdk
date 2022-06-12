<?php

namespace Memuya\Fab\Endpoints\Cards;

use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use Memuya\Fab\Endpoints\BaseConfig;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

class CardsConfig extends BaseConfig
{
    const PER_PAGE_MAX = 100;

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
     * @var Pitch
     */
    public Pitch $pitch;

    /**
     * The class to filter by.
     *
     * @var HeroClass
     */
    public HeroClass $class;

    /**
     * The cost to filter by.
     *
     * @var string
     */
    public string $cost;

    /**
     * The rarity to filter by.
     *
     * @var Rarity
     */
    public Rarity $rarity;

    /**
     * The set to filter by.
     *
     * @var Set
     */
    public Set $set;

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

    public function setPitch(Pitch $pitch): void
    {
        $this->pitch = $pitch;
    }

    public function setClass(HeroClass $class): void
    {
        $this->class = $class;
    }

    public function setCost(string $cost): void
    {
        $this->cost = $cost;
    }

    public function setRarity(Rarity $rarity): void
    {
        $this->rarity = $rarity;
    }

    public function setSet(Set $set): void
    {
        $this->set = $set;
    }

    public function __toString()
    {
        return $this->toQueryString();
    }
}