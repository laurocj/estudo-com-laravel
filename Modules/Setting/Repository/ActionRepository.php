<?php

namespace Modules\Setting\Repository;

use Modules\Setting\Entities\Action;
use App\Repository\GenericRepository;

class ActionRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->query = Action::query();
    }
}
