<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait GenericRepository
{

    /**
     * Get Model::class
     * @return Stirng
     */
    abstract public function getModel();


    /**
     * @param Array $columns
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*']): Collection
    {
        return $this->getModel()::all($columns);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return boolean
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id): Model
    {
        return $this->getModel()::find($id);
    }

    /**
     * @param  string  $value
     * @param  string|null  $key
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function lists(String $value, $key = 'id')
    {
        return $this->getModel()::pluck($value, $key)->all();
    }

    /**
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->getModel()::orderBy('id', 'DESC')->paginate($perPage);
    }

    /**
     * @param Array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Model
    {
        return $this->getModel()::create($attributes);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param Array $attributes
     *
     * @return boolean
     */
    public function update(Model $model, array $attributes): bool
    {
        return $model->update($attributes);
    }
}