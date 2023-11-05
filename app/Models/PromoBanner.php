<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\useUUID;


class PromoBanner extends Model
{
    use HasFactory, useUUID;
    protected $fillable = ['id', 'photo'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}
