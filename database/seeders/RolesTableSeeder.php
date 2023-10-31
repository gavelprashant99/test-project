<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Import the Role model

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        Role::create(['name' => 'ulb']);
        Role::create(['name' => 'state']);
        Role::create(['name' => 'district']);
        Role::create(['name' => 'admin']);
    }
}
