<?php

use Memuya\Fab\Fab;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\RequestConfig\CardsConfig;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

final class CardsConfigTest extends TestCase
{
    private $configData;

    public function setUp(): void
    {
        // This array follows the same order as the public properties in CardsConfig.
        $this->configData = [
            'page' => 1,
            'keywords' => 'search terms',
            'per_page' => 10,
            'pitch' => '3',
            'class' => 'brute',
            'cost' => '1',
            'rarity' => 'C',
            'set' => 'WTR',
        ];
    }

    public function testPerPageValidationViaContructor()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'per_page' => CardsConfig::PER_PAGE_MAX + 1,
        ]);
    }

    public function testPitchValidationViaContructor()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'pitch' => 'invalid_pitch',
        ]);
    }
    
    public function testClassValidationViaContructor()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'class' => 'invalid_class',
        ]);
    }
    public function testRarityValidationViaContructor()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'rarity' => 'invalid_rarity',
        ]);
    }
    public function testSetValidationViaContructor()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'set' => 'invalid_set',
        ]);
    }

    public function testQueryStringCreatedProperly()
    {
        $expected_output = http_build_query($this->configData);
        $config = new CardsConfig($this->configData);
        $query_string = $config->toQueryString();

        $this->assertIsString($query_string);
        $this->assertSame($expected_output, $query_string);
    }

    public function testCanSetPage()
    {
        $page = 10;
        $this->cardsConfig->setPage($page);

        $this->assertSame($page, $this->cardsConfig->page);
    }

    public function testCanSetValidPerPage()
    {
        $per_page = 100;
        $this->cardsConfig->setPerPage($per_page);

        $this->assertSame($per_page, $this->cardsConfig->per_page);
    }

    public function testCannotSetInvalidPerPage()
    {
        $this->expectException(InvalidCardConfigException::class);

        $per_page = CardsConfig::PER_PAGE_MAX + 1;
        $this->cardsConfig->setPerPage($per_page);
    }

    public function testCanSetValidPitch()
    {
        $pitch = '3';
        $this->cardsConfig->setPitch($pitch);

        $this->assertSame($pitch, $this->cardsConfig->pitch);
    }

    public function testCannotSetInvalidPitch()
    {
        $this->expectException(InvalidCardConfigException::class);

        $pitch = '4';
        $this->cardsConfig->setPitch($pitch);
    }

    public function testCanSetValidClass()
    {
        $class = 'brute';
        $this->cardsConfig->setClass($class);

        $this->assertSame($class, $this->cardsConfig->class);
    }

    public function testCannotSetInvalidClass()
    {
        $this->expectException(InvalidCardConfigException::class);

        $class = 'invalid';
        $this->cardsConfig->setClass($class);
    }

    public function testCanSetValidCost()
    {
        $cost = '5';
        $this->cardsConfig->setCost($cost);

        $this->assertSame($cost, $this->cardsConfig->cost);
    }

    public function testCanSetValidRarity()
    {
        $rarity = 'C';
        $this->cardsConfig->setRarity($rarity);

        $this->assertSame($rarity, $this->cardsConfig->rarity);
    }

    public function testCannotSetInvalidRarity()
    {
        $this->expectException(InvalidCardConfigException::class);

        $rarity = 'invalid';
        $this->cardsConfig->setRarity($rarity);
    }

    public function testCanSetValidSet()
    {
        $set = 'WTR';
        $this->cardsConfig->setSet($set);

        $this->assertSame($set, $this->cardsConfig->set);
    }

    public function testCannotSetInvalidSet()
    {
        $this->expectException(InvalidCardConfigException::class);

        $set = 'invalid';
        $this->cardsConfig->setSet($set);
    }
}