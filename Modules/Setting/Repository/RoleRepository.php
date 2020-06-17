<?php

namespace Modules\Setting\Repository;

use App\Repository\GenericRepository;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    public function __construct()
    {
        $this->query = Role::query();
    }
}
