<?php

namespace Modules\Setting\Repository;

use Modules\Setting\Entities\Role;
use App\Repository\GenericRepository;

class RoleRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->query = Role::query();
    }
}
