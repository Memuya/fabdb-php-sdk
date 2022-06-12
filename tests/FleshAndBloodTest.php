<?php

use Memuya\Fab\Client;
use Memuya\Fab\FleshAndBlood;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Exceptions\ResponseFormatNotSupportedException;

final class FleshAndBloodTest extends TestCase
{
    private FleshAndBlood $fab;

    public function setUp(): void
    {
        $this->fab = new FleshAndBlood(new Client);
    }

    public function testCanGetCards()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fab->getCards()
        );
    }
    
    public function testCanGetCard()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fab->getCard('eye-of-ophidia')
        );
    }

    public function testCanGetDeck()
    {
        $this->assertInstanceOf(
            stdClass::class,
            $this->fab->getDeck('lDDjYZbe')
        );
    }
}