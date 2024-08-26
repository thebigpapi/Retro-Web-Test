<?php

namespace App\Entity\Enum;

enum KnownIssueType:int {
    case Motherboards = 1;
    case ExpansionCards = 2;
    case HardDrives = 4;
    case OpticalDrives = 8;
    case FloppyDrives = 16;
    case Chips = 32;
}