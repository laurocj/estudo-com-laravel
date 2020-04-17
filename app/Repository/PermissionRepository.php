<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = Permission::query();
    }
}
