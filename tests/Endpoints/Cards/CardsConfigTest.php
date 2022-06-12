<?php

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
        $pitch = CardsConfig::PITCH_OPTIONS[0];
        $config = new CardsConfig(['pitch' => $pitch]);

        $this->assertSame($pitch, $config->pitch);
    }

    public function testCannotSetInvalidPitch()
    {
        $this->expectException(InvalidCardConfigException::class);

        $pitch = '10';
        new CardsConfig(['pitch' => $pitch]);
    }
    
    public function testCanSetValidClass()
    {
        $class = CardsConfig::CLASS_OPTIONS[0];
        $config = new CardsConfig(['class' => $class]);

        $this->assertSame($class, $config->class);
    }

    public function testCannotSetInvalidClass()
    {
        $this->expectException(InvalidCardConfigException::class);

        $class = 'invalid';
        new CardsConfig(['class' => $class]);
    }

    public function testCanSetValidCost()
    {
        $cost = '2';
        $config = new CardsConfig(['cost' => $cost]);

        $this->assertSame($cost, $config->cost);
    }
    
    public function testCanSetValidRarity()
    {
        $rarity = CardsConfig::RARITY_OPTIONS[0];
        $config = new CardsConfig(['rarity' => $rarity]);

        $this->assertSame($rarity, $config->rarity);
    }

    public function testCannotSetInvalidRarity()
    {
        $this->expectException(InvalidCardConfigException::class);

        $rarity = 'invalid';
        new CardsConfig(['rarity' => $rarity]);
    }
    
    public function testCanSetValidSet()
    {
        $set = CardsConfig::SET_OPTIONS[0];
        $config = new CardsConfig(['set' => $set]);

        $this->assertSame($set, $config->set);
    }

    public function testCannotSetInvalidSet()
    {
        $this->expectException(InvalidCardConfigException::class);

        $set = 'invalid';
        new CardsConfig(['set' => $set]);
    }

    public function testCanGenerateQueryStringWithDefaultConfig()
    {
        $config = new CardsConfig;

        $this->assertSame('page=1', $config->toQueryString());
    }
}