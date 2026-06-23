<?php

namespace App\Repository;

use App\Interfaces\Repository\RoleRInterface;
use App\Models\Role;
use Override;

class RoleRepository implements RoleRInterface
{
    #[Override]
    public function getAllRoles()
    {
        return Role::select('id', 'name', 'display_name')->get();
    }
}