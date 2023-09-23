<?php

namespace App\Form\Type;

enum ItemsPerPageType: int
{
    case Items24 = 24;
    case Items48 = 48;
    case Items100 = 100;
}
