<?php

use Memuya\Fab\Clients\File\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use PHPUnit\Framework\TestCase;

final class CardsConfigTest extends TestCase
{
    public function testCanSetValidName()
    {
        $name = 'test';
        $config = new CardsConfig(['name' => $name]);

        $this->assertSame($name, $config->name);
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
}
