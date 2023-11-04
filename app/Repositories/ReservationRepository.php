<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository
{

    public static function getReservation($idUser)
    {
        $reservations = Reservation::with(['docter.category', 'docter.images', 'docter.subdistrict'])->where('created_by', $idUser)->get();
        return $reservations;
    }
    public static function createReservation($data)
    {
        try {
            return Reservation::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function getReservationTodayForDocter($docterId)
    {
        $today = now()->startOfDay();
        $reservations = Reservation::with(['docter.category', 'docter.images', 'docter.subdistrict'])->whereDate('created_at', $today)->where('docter_id', $docterId)->get();
        return $reservations;
    }
}
