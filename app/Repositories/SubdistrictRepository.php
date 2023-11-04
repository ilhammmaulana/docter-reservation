<?php

namespace App\Repositories;

use App\Models\Subdistrict;

class SubdistrictRepository
{
    public function all()
    {
        return Subdistrict::orderBy('name', 'ASC')->get();
    }
}
