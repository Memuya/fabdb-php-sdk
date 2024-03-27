<?php

namespace Memuya\Fab\Enums;

enum CardType: string
{
    case NonAttack = 'non-attack';
    case AttackAction = 'attack action';
    case AttackReaction = 'attack reaction';
    case DefenseReaction = 'defense reaction';
    case Equipment = 'equipment';
    case Hero = 'hero';
    case Instant = 'instant';
    case Item = 'item';
    case Weapon = 'weapon';
}
