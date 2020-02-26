<?php

namespace App\Services;

use App\Repository\RoleRepository;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Services\PaginatedAbstract;

class RoleService
{

    /**
     * Role Repository
     *
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * Role Repository
     * @param RoleRepository
     *
     * @return this
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Create Role
     *
     * @param String $name
     * @param Array $permissions
     *
     * @return Role
     */
    public function create(String $name, array $permissions)
    {
        // Forma com function
        // $role = null;
        // DB::transaction(function() use (&$role ,$name ,$permissions) {
        //     $role = Role::create(['name' => $name]);
        //     $role->syncPermissions($permissions);
        // });

        // DB::beginTransaction();
        $role = $this->roleRepository->create(['name' => $name]);
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
    public function update(Role $role, array $newValue, array $permissions = [])
    {
        $attributes = [];
        foreach ($newValue as $column => $value) {
            if (!is_numeric($column)) {
                if (is_array($value) && $column == 'permissions') {
                    $permissions = array_merge($permissions, $value);
                } else
                if (is_string($column) && !is_array($value)) {
                    $attributes[$column] = $value;
                }
            }
        }

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $this->roleRepository->update($role, $attributes);
    }
}