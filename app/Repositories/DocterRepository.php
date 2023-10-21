<?php

namespace App\Repositories;

use App\Models\Docter;

class DocterRepository
{
    public function all()
    {
        $docters = Docter::with(['images', 'category', 'subdistrict'])->get();
        return $docters;
    }
    public function getDocterById($id)
    {
        return Docter::find($id);
    }
}
