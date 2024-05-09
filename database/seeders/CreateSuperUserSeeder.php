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
        $permission = Permission::create(['name' => 'estate.index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'notification.index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.destroy','guard_name' => 'web']);

        $permission = Permission::create(['name' => 'topic','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'banner','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'banner.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'faq','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'faq.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'faq.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'faq.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'faq.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'faq.destroy','guard_name' => 'web']);


        $permission = Permission::create(['name' => 'schedule.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'schedule.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'schedule.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'schedule.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'schedule.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'catalogue','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'catalogue.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'catalogue.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'catalogue.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'catalogue.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'catalogue.destroy','guard_name' => 'web']);

        $permission = Permission::create(['name' => 'estcontact','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'estcontact.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estcontact.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estcontact.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estcontact.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estcontact.destroy','guard_name' => 'web']);
        
        

        for($i=1; $i <= $permission->id; $i++) {
            \DB::table('role_has_permissions')->insert([
                'permission_id' =>  $i,
                'role_id' => $role->id
             ]);
        }
        // $role->syncPermissions($permission->id);
    }
}
