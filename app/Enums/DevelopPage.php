<?php

namespace App\Enums;

enum DevelopPage : string
{
    case Ads = 'ads';
    case Games = 'universes';

    /**
     * Gets the artificial types that are shown on the develop page.
     *
     * @return array
     */
    public static function developPages(): array
    {
        return [
            // self::Ads,
            self::Games
        ];
    }

    /**
     * Gets the Font Awesome icon for this develop page.
     *
     * @return string
     */
    public function fontAwesomeIcon(): string
    {
        return match($this) {
            self::Ads => 'fa-rectangle-ad',
            self::Games => 'fa-gamepad-modern',
        };
    }
}
