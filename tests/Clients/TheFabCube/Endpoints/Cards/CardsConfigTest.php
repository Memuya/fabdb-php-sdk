<?php

use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Cards\CardsConfig;

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

    public function testCanSetValidCost()
    {
        $cost = '2';
        $config = new CardsConfig(['cost' => $cost]);

        $this->assertSame($cost, $config->cost);
    }

    public function testCanSetValidPower()
    {
        $power = '2';
        $config = new CardsConfig(['power' => $power]);

        $this->assertSame($power, $config->power);
    }
}
