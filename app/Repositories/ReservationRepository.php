<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository{

    public static function getReservation($idUser){
        $reservations = Reservation::with(['docter.category', 'docter.images', 'docter.subdistrict'])->where('created_by', $idUser)->get();
        return $reservations;
    }
    public static function createReservation($data){
        try {
            return Reservation::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}