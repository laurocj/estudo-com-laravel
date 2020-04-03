<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait GenericRepository
{

    /**
     * Retorna a class que será usada
     *
     * @return Illuminate\Database\Eloquent\Model  Model::class
     */
    abstract public function getModel();


    /**
     * O mesmo que all do eloquent https://laravel.com/docs/5.8/eloquent#retrieving-models
     *
     * @param Array $columns
     * @param  int $limit
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'], $limit = 10): Collection
    {
        $columns = $this->realColumns($this->getModel(), $columns);
        return $this->getModel()::limit($limit)->get($columns);
    }

    /**
     * O mesmo que o delete do eloquent https://laravel.com/docs/5.8/eloquent#deleting-models
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    /**
     * O mesmo que find do eloquent https://laravel.com/docs/5.8/eloquent#retrieving-single-models
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id)
    {
        return $this->getModel()::find($id);
    }

    /**
     * Retorna uma list que pode ser usado em um select deve ser passado o nome da coluna que será apresentada
     *
     * @param  string  $value
     * @param  string|null  $key
     * @param  int|string $limit
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function lists($columns, $glue = " ", $limit = 10, $key = null)
    {
        if (is_null($key)) {
            $key = $this->getPrimaryKey();
        } else {
            $key = $this->realColumns($this->getModel(), $key);
        }

        $columns = $this->realColumns($this->getModel(), $columns);
        $columns = is_array($columns) ? $columns : [$columns];
        $select = $columns;
        $select[] = $key;
        $query = $this->getModel()::select($select)->whereNotNull($columns);

        if (is_numeric($limit)) {
            $query->limit($limit);
        }

        foreach ($columns as $column) {
            $query->where($column, '<>', '')->orderBy($column);
        }

        $collection = $query
            ->get()
            ->mapWithKeys(function ($item) use ($key, $glue, $columns) {
                return [$item->{$key} => implode($glue, $item->only($columns))];
            });

        return $collection;
    }

    /**
     * O paginate do laravel https://laravel.com/docs/5.8/pagination#paginating-eloquent-results
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage): \Illuminate\Pagination\LengthAwarePaginator
    {
        $key = $this->getPrimaryKey();
        return $this->getModel()::orderBy($key, 'DESC')->paginate($perPage);
    }

    /**
     * Uma forma de pesquisa nas tabelas
     * Envie um array com as tabelas onde se quer procurar e por último o campo
     *
     * @param Int $perPage
     * @param Array $fieldsForResearch ['turma.curso.Denominacao' => 'Capacitação', 'instrutor.nm_candidato' => "Pedro"];
     * @param String|null $orderBy coluna
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search(int $perPage, array $fieldsForResearch, $orderBy = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->getModel()::query();

        foreach ($this->realColumns($this->getModel(), $fieldsForResearch) as $field => $value) {
            if (strpos($field, '.') !== false) {
                $fields = explode('.', $field);

                if (count($fields) == 2) {
                    list($relationship, $field) = $fields;

                    $query->orWhereHas($relationship, function ($query) use ($field, $value) {
                        $field = $this->realColumns($query->getModel(), $field);
                        $query->where($query->getModel()->getTable() . "." . $field, 'LIKE', '%' . $value . '%');
                    });
                } else {
                    $relationship = array_shift($fields);

                    $query->orWhereHas($relationship, function ($query) use ($fields, $value) {
                        list($relationship, $field) = $fields;
                        $query->whereHas($relationship, function ($query) use ($field, $value) {
                            $field = $this->realColumns($query->getModel(), $field);
                            $query->where($query->getModel()->getTable() . "." . $field, 'LIKE', '%' . $value . '%');
                        });
                    });
                }
            } else {
                $query->orWhere($field, 'LIKE', '%' . $value . '%');
            }
        }

        if (!is_null($orderBy)) {
            $query->orderBy( $this->realColumns( $this->getModel(), $orderBy), 'ASC');
        }

        // return $query->paginate($perPage)->appends($fieldsForResearch);
        return $query->paginate($perPage);
    }

    /**
     * Classes que usam o FieldMapTrait podem precisar converter os atritutos em colunas do banco de dados
     * @param FieldMapTrait $clazz
     * @param array|string $fields
     * @return array|string
     */
    private function realColumns($clazz, $fields)
    {
        if(method_exists($clazz,'attributesToColumn')) {
            return $clazz::attributesToColumn($fields);
        }
        return $fields;
    }

    // /**
    //  * O mesmo que create do eloquent https://laravel.com/docs/5.8/eloquent#mass-assignment
    //  * @param Array $attributes
    //  *
    //  * @return \Illuminate\Database\Eloquent\Model
    //  */
    // public function create(array $attributes): Model
    // {
    //     return $this->getModel()::create($attributes);
    // }

    // /**
    //  *  O mesmo que update https://laravel.com/docs/5.8/eloquent#updates
    //  * @param int $id
    //  * @param Array $attributes
    //  *
    //  * @return boolean
    //  */
    // public function update(int $id, array $attributes): bool
    // {
    //     return $this->find($id)->update($attributes);
    // }

    /**
     * Obtem a string que correponde a primary key da tabela
     *
     * @return string
     */
    private function getPrimaryKey()
    {
        $clazz = $this->getModel();
        return (new $clazz)->getKeyName();
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
