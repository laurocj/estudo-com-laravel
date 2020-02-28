<?php

namespace App\Repository;

use App\Repository\GenericRepository;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    use GenericRepository;

    public function getModel()
    {
        return Role::class;
    }
}