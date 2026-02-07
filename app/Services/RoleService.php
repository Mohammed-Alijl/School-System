<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    /**
     * get Roles with permissions count
     */
    public function getAll()
    {
        return Role::withCount('permissions')->get();
    }

    /**
     * Get permissions grouped by his permissions
     * [
     * 'admins' => [PermissionObj, PermissionObj],
     * 'products' => [PermissionObj, ...],
     * ]
     */
    public function getGroupedPermissions()
    {
        $permissions = Permission::get();
        $grouped = [];

        foreach ($permissions as $permission) {
            $parts = explode('_', $permission->name, 2);

            $action = $parts[0];
            $model = $parts[1] ?? 'other';

            $grouped[$model][] = $permission;
        }

        return $grouped;
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

        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function update($role, array $data)
    {
        $role->update(['name' => $data['name']]);
        if (!empty($data['permissions'])) {
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
