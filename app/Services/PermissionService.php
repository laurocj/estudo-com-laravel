<?php

namespace App\Services;

use App\Repository\PermissionRepository;
use Spatie\Permission\Models\Permission;

class PermissionService
{

    /**
     * Permission Repository
     *
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * Permission Repository
     * @param PermissionRepository
     *
     * @return this
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
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
        return $this->permissionRepository->create([
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
    public function update(Permission $permission, array $newValue)
    {
        $attribules = [];
        foreach ($newValue as $column => $value) {
            $attribules[$column] = $value;
        }

        return $this->permissionRepository->update($permission, $attribules);
    }
}