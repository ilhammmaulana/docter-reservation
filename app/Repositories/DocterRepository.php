<?php

namespace App\Repositories;

use App\Models\Docter;

class DocterRepository
{
    public function all($paginate = false, $totalData = 10)
    {
        if($paginate){
            $docters = Docter::with(['images', 'category', 'subdistrict'])->paginate($totalData);
        }else{
            $docters = Docter::with(['images', 'category', 'subdistrict'])->get();

        }
        return $docters;
    }
    public function getDocterById($id)
    {
        return Docter::find($id);
    }
}
