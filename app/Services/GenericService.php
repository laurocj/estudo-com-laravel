<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GenericService
{

    /**
     * @var Model
     */
    private $model;

    /**
     * GenericService constructor.
     *
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = new $model;
        $this->checkModel($this->model);
    }

    /**
     * @param $model
     *
     * @return bool
     */
    protected function checkModel($model) : bool
    {
        if(!$model instanceof \Illuminate\Database\Eloquent\Model) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid instance of [%s], only instances of \Illuminate\Database\Eloquent\Model are allowed.',
                get_class($model)
            ));
        }

        return true;
    }

    /**
     * @param Array $columns
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*']) : Collection
    {
        return $this->model::all($columns);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return boolean
     */
    public function delete(Model $model) : bool
    {
        $this->checkModel($model);

        return $model->delete();
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id): Model
    {
        return $this->model::find($id);
    }

    /**
     * @param  string  $value
     * @param  string|null  $key
     * @return array
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function list(String $value, $key = 'id')
    {
        return $this->model::pluck($value, $key)->all();
    }

    /**
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage) : \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model::orderBy('id','DESC')->paginate($perPage);
    }

    /**
     * @param Array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createWith(Array $attributes) : Model
    {
        return $this->model::create($attributes);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param Array $attributes
     *
     * @return boolean
     */
    protected function updateIn(Model $model, Array $attributes) : bool
    {
        $this->checkModel($model);

        return $model->update($attributes);
    }
}
