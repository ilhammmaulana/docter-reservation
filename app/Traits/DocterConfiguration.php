<?php

namespace App\Traits;

use Illuminate\Support\Str;



trait DocterConfiguration
{
    public static function booted()
    {
        static::creating(function ($model) {
            $model->assignRole('docter');
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}