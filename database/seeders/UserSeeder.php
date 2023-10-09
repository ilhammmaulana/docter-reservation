<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => 'Ilham Maulana',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // password
            'phone' => "08954638229",
            'photo' => 'https://placehold.co/600x400?text=User+Photo'
        ])->assignRole('admin');

        User::factory(10)->create();
    }
}
