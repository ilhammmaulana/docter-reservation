<?php

namespace App\Models;

use App\Traits\DocterConfiguration;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Docter extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes, DocterConfiguration;
    protected $guard_name = 'docter';
    protected $table = 'docters';
    protected $fillable = ['name', 'email', 'password', 'photo', 'phone', 'subdistrict_id', 'description', 'address', 'category_docter_id'];
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
        return $this->belongsTo(CategoryDocter::class, 'category_docter_id');
    }

    public function images()
    {
        return $this->hasMany(DocterImage::class, 'docter_id');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_id');
    }


}
