<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Services\PaginatedAbstract;

class RoleService extends PaginatedAbstract {

    /**
     *  Get paged items
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPagedItems(int $perPage)
    {
        return $this->paginate(new Role, $perPage);
    }

    /**
     *  List
     *
     * @param  string  $value
     * @param  string|null  $key
     * @return array
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(String $value, $key = 'id')
    {
        return Role::pluck($value, $key)->all();
    }

    /**
     *  Get item by id
     *
     * @param int $id
     *
     * @return Role
     */
    public function find($id) {
        return Role::find($id);
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
        $role = Role::create(['name' => $name]);
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
        foreach($newValue as $column => $value) {
            if(!is_numeric($column)) {
                if(is_array($value) && $column == 'permissions') {
                    $permissions = array_merge($permissions,$value);
                } else {
                    $role->$column = $value;
                }
            }
        }

        if(!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $role->update();
    }

    /**
     * Delete the Role from the database.
     *
     * @param Role $role
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete(Role $role)
    {
        return $role->delete();
    }
}

