<?php

namespace App\Interfaces\Repository;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRInterface
{
    public function getPaginatedUsers(Request $request);

    public function create(Request $request) : void;

    public function update(Request $request, User $user);

    public function updatePassword(Request $request, User $user);
    
    public function delete(User $user);
}
