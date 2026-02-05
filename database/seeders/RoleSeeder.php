<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'admins'    => ['list', 'create', 'edit', 'delete', 'update_role'],
            'students'  => ['list', 'create', 'edit', 'delete', 'graduate', 'promote'],
            'teachers'  => ['list', 'create', 'edit', 'delete'],
            'sections'  => ['list', 'create', 'edit', 'delete'],
            'invoices'  => ['list', 'create', 'edit', 'delete', 'print'],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::create([
                    'name' => $module . '.' . $action,
                    'guard_name' => 'admin'
                ]);
            }
        }

        Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
    }
}
