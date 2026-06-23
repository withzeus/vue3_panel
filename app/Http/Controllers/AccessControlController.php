<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccessControlController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        return Inertia::render('AccessControl/Index', [
            '_layout' => 'Themed',
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all(),
            'users' => Inertia::optional(fn () => User::where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->with(['roles', 'permissions'])
                ->limit(10)
                ->get()
            ),
        ]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'required|string',
        ]);

        Role::create($request->only(['name', 'display_name', 'description']));

        return back()->with('success', 'Custom authorization group compiled successfully.');
    }

    public function syncRolePermissions(Request $request, Role $role)
    {
        $request->validate(['permissions' => 'array']);
        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Role authority matrices updated safely.');
    }

    public function syncUserAccess(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'allowed_permissions' => 'array',
            'denied_permissions' => 'array',
        ]);

        // 1. Sync structural roles
        $user->syncRoles($request->roles ?? []);

        // 2. Merge regular allowed permissions with prefixed denied permissions
        $allowed = $request->allowed_permissions ?? [];
        $denied = collect($request->denied_permissions ?? [])->map(function ($id) {
            // We find the permission text identifier and prefix it with 'deny:'
            $permName = Permission::find($id)?->name;

            // Find or dynamically create the matching deny permission record in the database
            if ($permName && ! str_starts_with($permName, 'deny:')) {
                $denyPerm = Permission::firstOrCreate([
                    'name' => 'deny:'.$permName,
                ], [
                    'display_name' => 'Deny: '.$permName,
                    'description' => 'Explicitly blocks access to '.$permName,
                ]);

                return $denyPerm->id;
            }

            return $id;
        })->filter()->toArray();

        // Combined sync array sent to Laratrust pivot table
        $user->syncPermissions(array_merge($allowed, $denied));

        return back()->with('success', 'User access rules modified successfully.');
    }
}
