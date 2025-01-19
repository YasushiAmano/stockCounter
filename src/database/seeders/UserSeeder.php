<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者ユーザーの作成
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('admin');

        // マネージャーユーザーの作成
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@manager.com',
            'password' => bcrypt('password')
        ]);
        $manager->assignRole('manager');

        // 一般ユーザーの作成
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@user.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('user');
    }
}
