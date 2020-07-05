<?php

namespace Modules\Setting\Repository;

use Modules\Setting\Entities\Acl;
use App\Repository\GenericRepository;

class AclRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->query = Acl::query();
    }
}
