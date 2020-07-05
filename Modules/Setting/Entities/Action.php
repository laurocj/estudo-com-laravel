<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Action
 *
 * @property int $id
 * @property string $name
 * @property int $resource_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|Acl[] $acls
 * @property Resource $resource
 */
class Action extends Model
{
    

    /**
     * Tabela correspondente desse modelo no banco de dados.
     *
     * @var string
     */
    protected $table = 'actions';

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
        return $this->hasMany('Modules\Setting\Entities\Acl', 'action_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resource()
    {
        return $this->hasOne('Modules\Setting\Entities\Resource', 'id', 'resource_id');
    }
    

}
