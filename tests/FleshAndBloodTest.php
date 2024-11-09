<?php

use Memuya\Fab\Clients\FabDb\FabDbClient;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\FleshAndBlood;
use PHPUnit\Framework\TestCase;

final class FleshAndBloodTest extends TestCase
{
    private FleshAndBlood $fabWithFileClient;
    private FleshAndBlood $fabWithFabDbClient;

    public function setUp(): void
    {
        $this->fabWithFileClient = new FleshAndBlood(new FileClient());
        $this->fabWithFabDbClient = new FleshAndBlood(new FabDbClient());
    }

    public function testCanGetCards()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fabWithFabDbClient->getCards()
        );
    }

    public function testCanGetCard()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fabWithFabDbClient->getCard('eye-of-ophidia')
        );
    }

    public function testCanGetDeck()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fabWithFabDbClient->getDeck('lDDjYZbe')
        );
    }
}
