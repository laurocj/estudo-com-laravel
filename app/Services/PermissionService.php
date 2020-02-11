<?php

namespace App\Services;

use App\Services\GenericService;
use Spatie\Permission\Models\Permission;

class PermissionService extends GenericService {

    public function __construct() {
        parent::__construct(Permission::class);
    }

    /**
     * Create Permission
     *
     * @param String $name
     *
     * @return Permission
     */
    public function create(String $name)
    {
        return parent::createWith([
            'name' => $name
        ]);
    }

    /**
     * Update Permission
     *
     * @param Permission $permission
     * @param Array $newValue
     *
     * @return boolean
     */
    public function update(Permission $permission, Array $newValue)
    {
        $attribules = [];
        foreach($newValue as $column => $value){
            $attribules[$column] = $value;
        }

        return parent::updateIn($permission,$attribules);
    }
}
