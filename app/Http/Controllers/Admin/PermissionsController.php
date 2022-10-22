<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Action;
use App\Enums\Actions;
use App\Roles\Roles;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->isSuperAdmin())
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function view()
    {
        return view('admin.permissions');
    }

    public function store(Request $request)
    {
        // 0xbaadc0de

        $rolesets = Roles::allRolesets();
        $view_rolesets = [];

        foreach ($rolesets as $roleset)
        {
            $view_rolesets[$roleset] = (object) [
                'name' => $roleset,
                'roles' => Roles::rolesOfRoleset($roleset),
                'basename' => basename(str_replace('\\', '/', $roleset)), // WHAT THE FUCK ??
            ];
        }

        if ($request->has('username'))
        {
            $request->validate([
                'username' => ['required', 'exists:users,username']
            ]);

            $user = User::select('id', 'username', 'permissions', 'superadmin')->where('username', $request->input('username'))->first();

            return view('admin.permissions', [
                'user' => $user,
                'rolesets' => $view_rolesets,
            ]);
        }

        if ($request->has('reset_for'))
        {
            $user = User::findOrFail($request->input('reset_for'));
            $user->forceSetPermissions(User::defaultPermissions());

            Session::flash('success', __('Successfully reset permissions for user <b>:username</b>!', ['username' => $user->username]));

            return view('admin.permissions', [
                'user' => $user,
                'rolesets' => $view_rolesets,
            ]);
        }

        try
        {
            $request->validate([
                'user' => ['required', 'exists:users,id']
            ]);
        }
        catch (ValidationException)
        {
            return back()->with('error', __('An unexpected error occurred. Please try again.'));
        }

        /**
         * Only permissions that are turned on are sent.
         * Additionally, field names are denominated in the format "roleset;role" prefixed with "permission__".
         * Example: "permission__App\Roles\Users;MODERATION_GENERAL_BAN"
         */

        $data = $request->all();

        if (count($data) > (count($rolesets) * 30)) // 30 flags per roleset, impossible to be above this
        {
            return back()->with('error', __('An unexpected error occurred. Please try again.'));
        }

        // We are manually recreating the users permissions based on what it sent
        $permissions = [];

        foreach ($data as $field => $value)
        {
            // If it doesn't start with permission__, leave it be
            if (!str_starts_with($field, 'permission__'))
            {
                continue;
            }

            if ($value != 'on')
            {
                continue;
            }

            // Has to be formatted per our spec
            $field = substr($field, strlen('permission__'));

            $flag = explode(';', $field);
            if (count($flag) !== 2)
            {
                return back()->with('error', __('An unexpected error occurred. Please try again.'));
            }

            $roleset = $flag[0];
            $role = $flag[1];

            // If the roleset doesn't exist, go away
            if (!in_array($roleset, $rolesets) || !class_exists($roleset))
            {
                return back()->with('error', __('An unexpected error occurred. Please try again.'));
            }

            // If the role doesn't exist, go away
            $roles = Roles::rolesOfRoleset($roleset);
            if (is_null($roles[$role]))
            {
                return back()->with('error', __('An unexpected error occurred. Please try again.'));
            }

            // If our permissions building array doesn't have this roleset set, set it as 0
            if (!isset($permissions[$roleset]))
            {
                $permissions[$roleset] = 0;
            }

            // Add this flag to the roleset
            $permissions[$roleset] |= $roles[$role];
        }

        // Fill in the blanks
        foreach ($rolesets as $roleset)
        {
            if (!isset($permissions[$roleset]))
            {
                $permissions[$roleset] = 0;
            }
        }

        $user = User::findOrFail($request->input('user'));
        $user->forceSetPermissions($permissions);
        Action::log($request->user(), Actions::ChangedUserPermissions, $user);

        Session::flash('success', __('Successfully updated permissions for user <b>:username</b>!', ['username' => $user->username]));

        return view('admin.permissions', [
            'user' => $user,
            'rolesets' => $view_rolesets,
        ]);
    }
}
