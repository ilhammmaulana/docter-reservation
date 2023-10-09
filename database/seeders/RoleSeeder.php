<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => "admin"
        ]);
        Role::create([
            'name' => "dokter"
        ]);
        Role::create([
            'name' => "user"
        ]);
        Role::create([
            'name' => "admin",
            "guard_name" => "api"
        ]);
        Role::create([
            'name' => "user",
            "guard_name" => "api"
        ]);
        Role::create([
            'name' => "dokter",
            "guard_name" => "api"
        ]);
    }
}
