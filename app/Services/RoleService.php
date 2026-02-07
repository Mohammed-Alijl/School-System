<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    /**
     * get Roles with permissions eager loading
     */
    public function getAll()
    {
        return Role::with('permissions')->get();
    }

    /**
     * get all permissions
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function store(array $data)
    {
        $role = Role::create(['name' => $data['name']]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function update($role, array $data)
    {
        $role->update(['name' => $data['name']]);
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function delete($role)
    {
        $role->delete();
        return true;
    }
}
