<?php

namespace App\Repositories;

use App\Models\Docter;

class DocterRepository
{
    public function all()
    {
    }
    public function getDocterById($id)
    {
        return Docter::find($id);
    }
}
