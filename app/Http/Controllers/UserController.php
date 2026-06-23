<?php

namespace App\Http\Controllers;

use App\Interfaces\Repository\RoleRInterface;
use App\Interfaces\Repository\UserRInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private UserRInterface $userRepository,
        private RoleRInterface $roleRepository,
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\User::class);

        return Inertia::render('Users/Index', [
            'users' => $this->userRepository->getPaginatedUsers($request),
            'roles'   => $this->roleRepository->getAllRoles(),
            'filters' => $request->only(['search']),
            '_layout' => 'Themed',
        ]);
    }

    public function create()
    {
        $this->authorize('create', \App\Models\User::class);

        return Inertia::render('Users/Form', [
            'roles'   => $this->roleRepository->getAllRoles(),
            '_layout' => 'Themed',
        ]);
    }

    public function store(Request $request)
    {   
        $this->authorize('store', \App\Models\User::class);

        $this->userRepository->create($request);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(\App\Models\User $user)
    {
        $this->authorize('view', $user);

        $user->load('roles:id,name,display_name');

        return Inertia::render('Users/View', [
            'user' => $user,
            '_layout' => 'Themed',
        ]);
    }

    public function edit(\App\Models\User $user)
    {
        $this->authorize('edit', $user);

        $user->load('roles:id,name,display_name');
        
        return Inertia::render('Users/Form', [
            'user' => $user,
            'roles'   => $this->roleRepository->getAllRoles(),
            '_layout' => 'Themed',
        ]);
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $this->authorize('update', $user);

        $this->userRepository->update($request, $user);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function profile(\App\Models\User $user)
    {
        $this->authorize('viewProfile', $user);

        return Inertia::render('Users/Profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at?->toDayDateTimeString(),
                'updated_at' => $user->updated_at?->toDayDateTimeString(),
            ],
            '_layout' => 'Themed',
        ]);
    }

    public function updateProfile(Request $request, \App\Models\User $user)
    {
        $this->authorize('updateProfile', $user);

        $this->userRepository->update($request, $user);

        if (! $request->isNotFilled('password')) {
            $this->userRepository->updatePassword($request, $user);
        }

        return redirect()->route('users.show', $user->id)->with('success', 'Password updated successfully.');

    }

    public function destroy(\App\Models\User $user)
    {
        $this->authorize('delete', $user);

        $this->userRepository->delete($user);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
