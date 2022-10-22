<?php

namespace App\Enums;

use Spatie\Color\Hex;
use Spatie\Color\Color;

// https://git.tadah.sipr/tadah/arbiter/-/blob/trunk/Tadah.Arbiter/Log.cs

enum ArbiterLogSeverity : int
{
    case Error = 0;
    case Warning = 1;
    case Event = 2;
    case Information = 3;
    case Debug = 4;
    case Boot = 5;

    /**
     * Gets the logs shorthand type ('information' => 'info', 'warning' => 'warn', etc.)
     *
     * @return string
     */
    public function event(): string
    {
        return match($this)
        {
            ArbiterLogSeverity::Error => 'error',
            ArbiterLogSeverity::Warning => 'warn',
            ArbiterLogSeverity::Event => 'event',
            ArbiterLogSeverity::Information => 'info',
            ArbiterLogSeverity::Debug => 'debug',
            ArbiterLogSeverity::Boot => 'boot',
        };
    }

    /**
     * Gets the log color.
     *
     * @return Color
     */
    public function color(): Color
    {
        return match($this)
        {
            ArbiterLogSeverity::Error => Hex::fromString('#E74856'),
            ArbiterLogSeverity::Warning => Hex::fromString('#F9F1A5'),
            ArbiterLogSeverity::Event => Hex::fromString('#3B78FF'),
            ArbiterLogSeverity::Information => Hex::fromString('#F2F2F2'),
            ArbiterLogSeverity::Debug => Hex::fromString('#0037DA'),
            ArbiterLogSeverity::Boot => Hex::fromString('#16C60C'),
        };
    }
}
