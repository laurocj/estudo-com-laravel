<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = Role::query();
    }
}
