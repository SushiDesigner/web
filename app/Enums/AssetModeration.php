<?php

namespace App\Enums;

enum AssetModeration : int
{
    case Pending = 0;
    case Approved = 1;
    case Declined = 2;
}
