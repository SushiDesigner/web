<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent as UserAgent;

class Agent extends UserAgent
{
    /**
     * The FontAwesome icon of the user agent.
     *
     * @return string
     */
    public function icon(): string
    {
        if ($this->isDesktop())
        {
            return 'fa-display';
        }

        if ($this->isTablet())
        {
            return 'fa-tablet';
        }

        if ($this->isPhone())
        {
            return 'fa-mobile';
        }

        return 'fa-question';
    }
}
