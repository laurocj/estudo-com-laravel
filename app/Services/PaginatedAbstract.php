<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class PaginatedAbstract
{

    abstract protected function getPagedItems(int $perPage);

    /**
     *  Get paged items
     * @param Illuminate\Database\Eloquent\Model $model
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(Model $model, int $perPage) {

        return $model::paginate($perPage);
    }
}
