<?php

namespace App\Enums;

enum PlaceSort : int
{
    case MostPopular = 0;
    case MostVisited = 1;
    case MostFavorited = 2;
    case RecentlyUpdated = 3;
    case Featured = 4;

    /**
     * Gets the sort's name
     *
     * @return string
     */
    public function fullname(): string
    {
        return match($this)
        {
            self::MostPopular => 'Popular',
            self::MostVisited => 'Most Visited',
            self::MostFavorited => 'Most Favorited',
            self::RecentlyUpdated => 'Recently Updated',
            default => $this->name
        };
    }
}
