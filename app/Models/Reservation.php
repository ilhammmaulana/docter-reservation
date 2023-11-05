<?php

namespace App\Models;

use App\Traits\ReservationTrait;
use App\Traits\useUUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, ReservationTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'time_reservation', 'time_arrival','done_at','verify_at', 'remarks', 'status', 'docter_id', 'created_by', 'queue_number', 'remark_cancel'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function docter()
    {
        return $this->belongsTo(Docter::class, 'docter_id');
    }
    public static function generateQueueNumber($docterId)
    {
        $today = now()->startOfDay();
        $existingReservations = static::where('docter_id', $docterId)
            ->whereNotIn('status', ['hold', 'cancel'])
            ->whereDate('created_at', $today)
            ->count();

        return $existingReservations + 1;
    }
}
