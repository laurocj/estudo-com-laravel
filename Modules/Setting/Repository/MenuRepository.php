<?php

namespace Modules\Setting\Repository;

use Modules\Setting\Entities\Menu;
use App\Repository\GenericRepository;

class MenuRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->query = Menu::query();
    }
}
