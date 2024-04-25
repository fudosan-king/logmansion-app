<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoleHasPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin', 
            'email' => 'superadmin@propolife.co.jp', 
            'password' => 'super1234'
        ]);
        $role = Role::create(['name' => '管理者']); 
        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@propolife.co.jp', 
            'password' => 'admin1234'
        ]);
        $role = Role::create(['name' => 'ユーザー']); 
        $user->assignRole([$role->id]);

        $permission = Permission::create(['name' => 'dashboard','guard_name' => 'web']); 
        $role->syncPermissions($permission->id);
    }
}
