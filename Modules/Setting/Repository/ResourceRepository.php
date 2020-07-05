<?php

namespace Modules\Setting\Repository;

use Modules\Setting\Entities\Resource;
use App\Repository\GenericRepository;

class ResourceRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->query = Resource::query();
    }
}
