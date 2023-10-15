<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Docter extends Model
{
    use HasFactory, HasRoles, SoftDeletes, useUUID;
    protected $table = 'docters';
    protected $fillable = ['name', 'email', 'phone', 'password', 'photo'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $hidden = ['password'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'docter_id');
    }
    public function category()
    {
        return $this->belongsTo(CategoryDocter::class);
    }

    public function images()
    {
        return $this->hasMany(DocterImage::class, 'docter_id');
    }
}
