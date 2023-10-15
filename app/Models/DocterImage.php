<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocterImage extends Model
{
    use HasFactory;


    public function docter()
    {
        return $this->belongsTo(Docter::class, 'docter_id');
    }
}
