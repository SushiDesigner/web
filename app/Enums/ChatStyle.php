<?php

namespace App\Enums;

// https://anaminus.github.io/api/type/ChatStyle.html

enum ChatStyle : int
{
    case Classic = 0;
    case Bubble = 1;
    case ClassicAndBubble = 2;
}
