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

    public function testPerPageValidation()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'per_page' => CardsConfig::PER_PAGE_MAX + 1,
        ]);
    }

    public function testPitchValidation()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'pitch' => 'invalid_pitch',
        ]);
    }
    
    public function testClassValidation()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'class' => 'invalid_class',
        ]);
    }
    public function testRarityValidation()
    {
        $this->expectException(InvalidCardConfigException::class);

        $config = new CardsConfig([
            'rarity' => 'invalid_rarity',
        ]);
    }
    public function testSetValidation()
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
}