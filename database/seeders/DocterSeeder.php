<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $docterUmum = '32823989';
        $data = collect([
            "name" => "Docter Enggar",
            "address" => "Jalan Gaharu No 23, Semarang Banyumanik Jawa Tenggah",
            "category_id" => $docterUmum
        ]);
    }
}
