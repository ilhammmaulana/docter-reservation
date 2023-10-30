<?php

namespace App\Repositories;

use App\Models\Docter;

class DocterRepository
{
    public static function searchDocter($q)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])->where('name', 'like', "%" . $q . "%")->get();
        return $docters;
    }
    public function all($paginate = false, $totalData = 10)
    {
        if ($paginate) {
            $docters = Docter::with(['images', 'category', 'subdistrict'])->latest()->paginate($totalData);
        } else {
            $docters = Docter::with(['images', 'category', 'subdistrict'])->get();
        }
        return $docters;
    }
    public function getDocterById($id)
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])->where('id', $id)->firstOrFail();
        return $docters;
    }
}
