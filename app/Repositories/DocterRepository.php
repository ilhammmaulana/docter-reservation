<?php

namespace App\Repositories;

use App\Models\CategoryDocter;
use App\Models\Docter;
use App\Models\Subdistrict;

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

    public function getDocterBySubdistrictId($subdistrictId)
    {
        Subdistrict::findOrFail($subdistrictId);
        $docters = Docter::with(['images', 'category', 'subdistrict'])->where('subdistrict_id', $subdistrictId)->get();
        return $docters;
    }
    public function getDocterByCategoryId($categoryId)
    {
        CategoryDocter::findOrFail($categoryId);
        $docters = Docter::with(['images', 'category', 'subdistrict'])->where('category_docter_id', $categoryId)->get();
        return $docters;
    }
}
