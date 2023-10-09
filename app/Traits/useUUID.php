<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * 
 */
trait useUUID
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
