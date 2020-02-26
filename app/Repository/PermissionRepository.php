<?php

namespace App\Repository;

use App\Repository\GenericRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends GenericRepository
{
    public function __construct()
    {
        parent::__construct(Permission::class);
    }
}