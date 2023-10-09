<?php

namespace Database\Seeders;

use App\Models\Subdistrict;
use Illuminate\Database\Seeder;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["districts_id" => 1759, "name" => "Banyumanik", "zip_code" => 50261, "city_id" => 116],
            ["districts_id" => 1760, "name" => "Candisari", "zip_code" => 50252, "city_id" => 116],
            ["districts_id" => 1761, "name" => "Gajah Mungkur", "zip_code" => 50231, "city_id" => 116],
            ["districts_id" => 1762, "name" => "Gayamsari", "zip_code" => 50162, "city_id" => 116],
            ["districts_id" => 1763, "name" => "Genuk", "zip_code" => 50111, "city_id" => 116],
            ["districts_id" => 1764, "name" => "Gunungpati", "zip_code" => 50221, "city_id" => 116],
            ["districts_id" => 1765, "name" => "Mijen", "zip_code" => 50211, "city_id" => 116],
            ["districts_id" => 1766, "name" => "Ngaliyan", "zip_code" => 50181, "city_id" => 116],
            ["districts_id" => 1767, "name" => "Pedurungan", "zip_code" => 50113, "city_id" => 116],
            ["districts_id" => 1768, "name" => "Semarang Barat", "zip_code" => 50141, "city_id" => 116],
            ["districts_id" => 1769, "name" => "Semarang Selatan", "zip_code" => 50241, "city_id" => 116],
            ["districts_id" => 1770, "name" => "Semarang Tengah", "zip_code" => 50131, "city_id" => 116],
            ["districts_id" => 1771, "name" => "Semarang Timur", "zip_code" => 50122, "city_id" => 116],
            ["districts_id" => 1772, "name" => "Semarang Utara", "zip_code" => 50171, "city_id" => 116],
            ["districts_id" => 1773, "name" => "Tembalang", "zip_code" => 50271, "city_id" => 116],
            ["districts_id" => 1774, "name" => "Tugu", "zip_code" => 50151, "city_id" => 116],
        ];


        foreach ($data as $record) {
            Subdistrict::create([
                "name" => $record['name']
            ]);
        }
    }
}
