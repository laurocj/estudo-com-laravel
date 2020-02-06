<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesService {

    public function createRoles(String $name, Array $permission) : Role
    {
        // Forma com function
        // $role = null;
        // DB::transaction(function() use (&$role ,$name ,$permission) {
        //     $role = Role::create(['name' => $name]);
        //     $role->syncPermissions($permission);
        // });

        DB::beginTransaction();
        $role = Role::create(['name' => $name]);
        $role->syncPermissions($permission);
        DB::commint();

        return $role;
    }
}
