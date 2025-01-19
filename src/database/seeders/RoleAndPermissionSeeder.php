<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // パーミッションの作成
        $permissions = [
            'view_admin_page',
            'view_manager_page',
            'view_user_page'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // admin ロールの作成と権限付与
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        // manager ロールの作成と権限付与
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view_manager_page',
            'view_user_page'
        ]);

        // user ロールの作成と権限付与
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view_user_page'
        ]);
    }
}
