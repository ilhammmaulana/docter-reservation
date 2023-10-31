<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository{
    public static function createReservation($data){
        return Reservation::create($data);
    }
}