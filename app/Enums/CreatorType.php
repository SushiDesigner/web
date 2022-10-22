<?php

namespace App\Enums;

// https://anaminus.github.io/api/type/CreatorType.html

enum CreatorType : int
{
    case User = 0;
    case Group = 1;
}
