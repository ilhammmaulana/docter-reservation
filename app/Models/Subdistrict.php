<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory, useUUID;
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'subdistricts';
    protected $hidden = ['created_at', 'updated_at'];


    public function users()
    {
        return $this->hasMany(User::class, 'subdistrict_id');
    }
}
