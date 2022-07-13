<?php

namespace Memuya\Fab\Enums;

enum Rarity: string
{
    case Common = 'C';
    case Rare = 'R';
    case SuperRare = 'S';
    case Majestic = 'M';
    case Legendary = 'L';
    case Fabled = 'F';
    case Token = 'T';
    case Promo = 'P';
    case Marvel = 'MV';
}
