<?php

use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

final class CardsConfigTest extends TestCase
{
    public function testCanSetValidPage()
    {
        $page = 10;
        $config = new CardsConfig(['page' => $page]);

        $this->assertSame($page, $config->page);
    }

    public function testCanSetValidPerPage()
    {
        $per_page = CardsConfig::PER_PAGE_MAX - 1;
        $config = new CardsConfig(['per_page' => $per_page]);

        $this->assertSame($per_page, $config->per_page);
    }

    public function testCannotSetInvalidPerPage()
    {
        $this->expectException(InvalidCardConfigException::class);

        $per_page = CardsConfig::PER_PAGE_MAX + 1;

        new CardsConfig(['per_page' => $per_page]);
    }

    public function testCanSetValidPitch()
    {
        $config = new CardsConfig(['pitch' => Pitch::One]);

        $this->assertSame(Pitch::One, $config->pitch);
    }
    
    public function testCanSetValidClass()
    {
        $config = new CardsConfig(['class' => HeroClass::Brute]);

        $this->assertSame(HeroClass::Brute, $config->class);
    }

    public function testCanSetValidCost()
    {
        $cost = '2';
        $config = new CardsConfig(['cost' => $cost]);

        $this->assertSame($cost, $config->cost);
    }
    
    public function testCanSetValidRarity()
    {
        $config = new CardsConfig(['rarity' => Rarity::Rare]);

        $this->assertSame(Rarity::Rare, $config->rarity);
    }
    
    public function testCanSetValidSet()
    {
        $config = new CardsConfig(['set' => Set::Everfest]);

        $this->assertSame(Set::Everfest, $config->set);
    }

    public function testCanGenerateQueryStringWithDefaultConfig()
    {
        $config = new CardsConfig;

        $this->assertSame('page=1', $config->toQueryString());
    }
}