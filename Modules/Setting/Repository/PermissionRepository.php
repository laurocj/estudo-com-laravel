<?php

namespace Modules\Setting\Repository;

use App\Repository\GenericRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    public function __construct()
    {
        $this->query = Permission::query();
    }
}
