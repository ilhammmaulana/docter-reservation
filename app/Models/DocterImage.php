<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocterImage extends Model
{
    use HasFactory, useUUID;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['image', 'docter_id'];

    public function docter()
    {
        return $this->belongsTo(Docter::class, 'docter_id');
    }
}
