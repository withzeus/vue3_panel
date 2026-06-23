<?php

namespace App\Repository;

use App\Interfaces\Repository\UserRInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Override;

class UserRepository implements UserRInterface
{
    #[Override]
    public function getPaginatedUsers(Request $request)
    {
        $query = User::query()->with('roles:id,name,display_name');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $roleName = $request->input('role');
            // whereHas inspects the linked roles pivot table records
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        if ($request->filled('created_at')) {
            try {
                $date = Carbon::parse($request->input('created_at'))->toDateString();
                $query->whereDate('created_at', $date);
            } catch (\Exception $e) {
                // Handle or skip fallback if date formatting string payload is malformed
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return $users;
    }

    #[Override]
    public function create(Request $request): void
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($validated['role']) {
            $user->syncRoles([$validated['role']]);
        }
    }

    #[Override]
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$user->id}"],
        ]);

        $user->update($validated);

        $validated = $request->validate([
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if (isset($validated['role']) && $validated['role']) {
            $user->syncRoles([$validated['role']]);
        }

        $containsPwUpdate = $validated['password'] != (null || '');

        if ($containsPwUpdate) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }
    }

    #[Override]
    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
    }

    #[Override]
    public function delete(User $user)
    {
        if ($user->id === Auth::id()) {
            throw ValidationException::withMessages([
                'error' => 'You cannot delete your own administrative account.',
            ]);
        }

        $user->delete();
    }
}
