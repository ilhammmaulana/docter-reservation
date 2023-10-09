<?php

namespace App\Traits;

use Illuminate\Support\Str;



trait AssignRoleUser
{
    public static function booted()
    {
        static::creating(function ($model) {
            $model->assignRole('user');
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
