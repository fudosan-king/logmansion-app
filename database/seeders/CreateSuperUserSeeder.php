<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoleHasPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;
use Illuminate\Support\Arr;
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
        $permission = Permission::create(['name' => 'users.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'users.update','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'dashboard','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.destroy','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'estate.view','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.archive_index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'estate.getEstateSchedules','guard_name' => 'web']); 
    
        $permission = Permission::create(['name' => 'client.index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'client.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'client.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'client.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'client.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'client.view','guard_name' => 'web']); 
 
        $permission = Permission::create(['name' => 'notification.index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'notification.destroy','guard_name' => 'web']);

        $permission = Permission::create(['name' => 'topic.index','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'topic.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'banner.index','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'banner.create','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.edit','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'banner.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'faq.index','guard_name' => 'web']);
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

        $permission = Permission::create(['name' => 'catalogue.index.up','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'catalogue.index.down','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'catalogue.index','guard_name' => 'web']);
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
        $permission = Permission::create(['name' => 'estcontact.getDocSearch','guard_name' => 'web']);
        
        $permission = Permission::create(['name' => 'doc.edit','guard_name' => 'web']);
        $permission = Permission::create(['name' => 'doc.store','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'doc.permanent','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'doc.update','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'doc.destroy','guard_name' => 'web']); 

        $permission = Permission::create(['name' => 'profile','guard_name' => 'web']); 
        $permission = Permission::create(['name' => 'profile.update','guard_name' => 'web']); 
    
        for($i=1; $i <= $permission->id; $i++) {
            \DB::table('role_has_permissions')->insert([
                'permission_id' =>  $i,
                'role_id' => $role->id
             ]);
        }
    
        $locales = ['en_GB', 'vn_VN'];
        $faker = Factory::create(Arr::random($locales));
        
        for($i=1; $i <= 10; $i++) {
            \DB::table('estate_banners')->insert([
                'banner_type' => rand(0,1),
                'banner_title' => $faker->name,
                'banner_description' => $faker->paragraphs(2,true),
                'banner_image' => '/banner/'.rand(1,5).'.jpg',
                'banner_url' =>  $faker->url(),
                'banner_active' => rand(0,1),
            ]);
        }

        for($i=1; $i <= 10; $i++) {
            \DB::table('catalogue')->insert([
                'cata_title' => $faker->name,
                'cata_description' => $faker->paragraphs(2,true),
                'cata_image' => '/banner/'.rand(1,5).'.jpg',
                'cata_url' => $faker->url(),
                'cata_active' => rand(0,1),
                'cata_index' => rand(0,10),
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }

        for($i=1; $i <= 10; $i++) {
            \DB::table('estate_clients')->insert([
                'client_id' => 'Est'. sprintf("%06d", $i),
                'est_id' =>   $i,
                'client_name' => $faker->name,
                'client_f_name' => $faker->firstName,
                'client_l_name' => $faker->lastName,
                'client_furigana' => 'abc',
                'client_email' => $faker->email,
                'client_password' => Hash::make('super1234'),
                'client_tel' => $faker->phoneNumber,
         ]);
        }
      
        for($i=1; $i <= 5; $i++) {
            $contact_type = rand(0,2);
            \DB::table('estate_contact')->insert([
                'client_id' => 'Est'. sprintf("%06d", $i),
                'contact_type' =>   $contact_type,
                'contact_spot' =>  ($contact_type == 2 ? $contact_type = rand(0,8): null),
                'contact_status' =>  rand(0,3),
                'contact_title' => $faker->sentence,
                // 'contact_comment' => $faker->paragraphs(2,true),
                'updated_at' => now(),
                'created_at' => now(),
                'user_id' => rand(1,2),
            ]);
        }

        for($i=1; $i <= 100; $i++) {
            \DB::table('estate_contact_detail')->insert([
                'contact_id' => rand(1,5),
                'contact_message' =>  $faker->sentence,
                'author' =>   rand(1,2),
                'author_type' =>  rand(0,1),
                'contact_note' =>  $faker->sentence,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }

        for($i=1; $i <= 200; $i++) {
            \DB::table('estate_contact_attach')->insert([
                'contact_detail_id' => rand(1,100),
                'path_file' => 'test/'.rand(1,5).'.jpg' ,
            ]);
        }

    }
}
