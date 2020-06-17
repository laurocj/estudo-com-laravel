<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Menu
 *
 * @property int $id
 * @property string $name
 * @property string $route
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 */
class Menu extends Model
{
    use SoftDeletes;


    /**
     * Tabela correspondente desse modelo no banco de dados.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * A coluna no banco de dados que corresponde ao id da tabela.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indica se o modelo deve ser marcado com data e hora.
     *
     * @var bool
     */
    public $timestamps = false;



}
