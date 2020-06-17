<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ModelHasPermission $modelHasPermission
 * @property RoleHasPermission $roleHasPermission
 */
class Permission extends Model
{
    

    /**
     * Tabela correspondente desse modelo no banco de dados.
     *
     * @var string
     */
    protected $table = 'permissions';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modelHasPermission()
    {
        return $this->hasOne('Modules\Setting\Entities\ModelHasPermission', 'permission_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roleHasPermission()
    {
        return $this->hasOne('Modules\Setting\Entities\RoleHasPermission', 'permission_id', 'id');
    }
    

}
