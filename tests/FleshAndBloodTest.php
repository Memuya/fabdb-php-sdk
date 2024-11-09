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
        $this->fabWithFileClient = new FleshAndBlood(new FileClient('/app/cards.json'));
        $this->fabWithFabDbClient = new FleshAndBlood(new FabDbClient());
    }

    public function testCanGetCardsFromFabDb()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fabWithFabDbClient->getCards()
        );
    }

    public function testCanGetCardFromFabDb()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fabWithFabDbClient->getCard('eye-of-ophidia')
        );
    }

    public function testCanGetDeckFromFabDb()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fabWithFabDbClient->getDeck('lDDjYZbe')
        );
    }

    public function testCanGetCardsFromFile()
    {
        $this->assertIsArray($this->fabWithFileClient->getCards());
    }

    public function testCanGetCardFromFile()
    {
        $result = $this->fabWithFileClient->getCard('Eye of Ophidia');

        $this->assertIsArray($result);
        $this->assertSame($result['name'], 'Eye of Ophidia');
    }

    public function testCanGetDeckFromFile()
    {
        $result = $this->fabWithFileClient->getDeck('slug');

        // File does not support decks so it'll always be an empty array.
        $this->assertEmpty($result);
        $this->assertIsArray($result);
    }
}
