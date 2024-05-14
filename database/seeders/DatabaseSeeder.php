<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CreateSuperUserSeeder;
use Database\Seeders\FaqSeeder;
use Database\Seeders\NotificationSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([CreateSuperUserSeeder::class]);
       $this->call([EstateSeeder::class]);
       $this->call([FaqSeeder::class]);
       $this->call([NotificationSeeder::class]);
    }
}
