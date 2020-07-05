<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Acl
 *
 * @property int $id
 * @property int $role_id
 * @property int $action_id
 * @property int $resource_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Action $action
 * @property Resource $resource
 * @property Role $role
 */
class Acl extends Model
{
    

    /**
     * Tabela correspondente desse modelo no banco de dados.
     *
     * @var string
     */
    protected $table = 'acls';

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
    public function action()
    {
        return $this->hasOne('Modules\Setting\Entities\Action', 'id', 'action_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resource()
    {
        return $this->hasOne('Modules\Setting\Entities\Resource', 'id', 'resource_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne('Modules\Setting\Entities\Role', 'id', 'role_id');
    }
    

}
