<?php

namespace Database\Seeders;

use App\Models\CategoryDocter;
use App\Models\Docter;
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
        $docterUmum = CategoryDocter::where('name', 'Dokter Umum')->first();
        $data = collect([
            [
                "name" => "Docter Enggar",
                "address" => "Jalan Gaharu No 23, Semarang Banyumanik Jawa Tenggah",
                "category_docter_id" => $docterUmum->id,
                "password" => bcrypt('password_docter'),
                "phone" => "082398239",
                "email" => "engar34@gmail.com"
            ],
            [
                "name" => "dr. Yonathan Ardhana Christanto",
                "address" => "Bina Sehat Dental Clinic, Semarang Utara, Semarang",
                "category_docter_id" => $docterUmum->id,
                "password" => bcrypt('password_docter'),
                "phone" => "0818298329",
                "email" => "yonathan29@yahoo.com"   
            ]
        ]);

        $data->each(function($data) {
            Docter::create($data);
        });

    }
}