<?php

namespace App\Roles;

use App\Roles\Admin;
use App\Roles\Economy;
use App\Roles\Forums;
use App\Roles\GameServers;
use App\Roles\Places;
use App\Roles\SelfHostedServers;
use App\Roles\Users;

class Roles
{
    /**
     * Gets all rolesets.
     *
     * @return array
     */
    public static function allRolesets(): array
    {
        /**
         * This is an *ordered list.* Do not modify the order. Only append to it.
         */
        return [
            Admin::roleset(),
            Economy::roleset(),
            Forums::roleset(),
            GameServers::roleset(),
            Places::roleset(),
            SelfHostedServers::roleset(),
            Users::roleset()
        ];
    }

    /**
     * Gets all roles of a given roleset.
     *
     * @return array
     */
    public static function rolesOfRoleset($roleset): array
    {
        $reflector = new \ReflectionClass($roleset);
        return $reflector->getConstants();
    }

    /**
     * Get all roles in all rolesets.
     *
     * @return array
     */
    public static function allRoles(): array
    {
        $rolesets = self::allRoleSets();
        $roles = [];

        foreach ($rolesets as $roleset)
        {
            $roles = array_merge($roles, self::rolesOfRoleset($roleset));
        }

        return $roles;
    }
}
