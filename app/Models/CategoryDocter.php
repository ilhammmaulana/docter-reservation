<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDocter extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function docters()
    {
        return $this->hasMany(Docter::class, 'category_id');
    }
}
