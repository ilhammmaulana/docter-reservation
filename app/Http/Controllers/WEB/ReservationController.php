<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(){
        return view('pages.reservations', [
            'reservations' => ReservationRepository::getReservationTodayForDocter(getDataUser()->id)
        ]);
    }
    public function verify($id){
        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id',$id)->firstOrFail();
        if($reservation->docter->id !=== $idDocter){
            return redirect()->route('reservations.index')->with('error','You not have access!');
        }
        $reservation->update([
            'status' => 'verify'
        ]);
        return redirect()->route('reservations.index')->with('success','Success verify');
    }
}
