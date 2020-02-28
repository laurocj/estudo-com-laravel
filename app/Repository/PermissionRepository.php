<?php

namespace App\Repository;

use App\Repository\GenericRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    use GenericRepository;

    public function getModel()
    {
        return Permission::class;
    }
}