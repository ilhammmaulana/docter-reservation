<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ReservationTrait
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();            
            $docterId = $model->docter_id;
            $queueNumber = static::generateQueueNumber($docterId);
            $model->queue_number = $queueNumber;
        });
    }

    public static function generateQueueNumber($docterId)
    {
        $today = now()->startOfDay();
        $existingReservations = static::where('docter_id', $docterId)
            ->whereDate('created_at', $today)
            ->count();
        return $existingReservations + 1;
    }
}
