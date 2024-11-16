<?php

namespace Memuya\Fab\Clients\File;

enum ConfigType
{
    case MultiCard; // Client::getCards()
    case SingleCard; // Client::getCard()
}
