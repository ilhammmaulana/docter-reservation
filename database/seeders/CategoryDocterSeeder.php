<?php

namespace Database\Seeders;

use App\Models\CategoryDocter;
use Illuminate\Database\Seeder;

class CategoryDocterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = collect([
            [
                "name" => "Dokter Umum"
            ],
            [
                "name" => "Dokter Gigi"
            ],
            [
                "name" => "Dokter Kulit Dan Kelamin"
            ],
        ]);

        $data->each(function ($data) {
            CategoryDocter::create($data);
        });
    }
}
