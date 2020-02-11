<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Services\PaginatedAbstract;

class RoleService  extends GenericService {

    public function __construct() {
        parent::__construct(Role::class);
    }

    /**
     * Create Role
     *
     * @param String $name
     * @param Array $permissions
     *
     * @return Role
     */
    public function create(String $name, Array $permissions)
    {
        // Forma com function
        // $role = null;
        // DB::transaction(function() use (&$role ,$name ,$permissions) {
        //     $role = Role::create(['name' => $name]);
        //     $role->syncPermissions($permissions);
        // });

        // DB::beginTransaction();
        $role = parent::createWith(['name' => $name]);
        $role->syncPermissions($permissions);
        // DB::commint();

        return $role;
    }

    /**
     * Update Role
     *
     * @param Role $role
     * @param Array $newValue
     * @param Array $permissions
     *
     * @return boolean
     */
    public function update(Role $role, Array $newValue, Array $permissions = [])
    {
        $attributes = [];
        foreach($newValue as $column => $value) {
            if(!is_numeric($column)) {
                if(is_array($value) && $column == 'permissions') {
                    $permissions = array_merge($permissions,$value);
                } else
                if(is_string($column) && !is_array($value)) {
                    $attributes[$column] = $value;
                }
            }
        }

        if(!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return parent::updateIn($role,$attributes);
    }
}

