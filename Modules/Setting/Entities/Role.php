<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|Acl[] $acls
 */
class Role extends Model
{
    

    /**
     * Tabela correspondente desse modelo no banco de dados.
     *
     * @var string
     */
    protected $table = 'roles';

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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acls()
    {
        return $this->hasMany('Modules\Setting\Entities\Acl', 'role_id', 'id');
    }
    

}
