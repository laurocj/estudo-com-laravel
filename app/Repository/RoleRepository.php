<?php

namespace App\Repository;

use App\Repository\GenericRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends GenericRepository
{
    public function __construct()
    {
        parent::__construct(Role::class);
    }
}