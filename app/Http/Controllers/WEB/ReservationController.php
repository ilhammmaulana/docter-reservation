<?php

namespace App\Http\Controllers\WEB;

use App\Helpers\FCM;
use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\CancelReservationRequest;
use App\Models\Reservation;
use App\Models\User;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('pages.reservations', [
            'reservations' => ReservationRepository::getReservationTodayForDocter(getDataUser()->id)
        ]);
    }
    public function show($id)
    {
        return view('pages.reservations-detail', [
            'reservation' => ReservationRepository::getOne($id)
        ]);
    }
    public function verify($id)
    {
        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id', $id)->firstOrFail();
        if ($reservation->docter->id !== $idDocter) {
            return redirect()->route('reservations.index')->with('error', 'You not have access!');
        }
        $queueNumber = Reservation::generateQueueNumber($idDocter);
        $reservation->update([
            'status' => 'verify',
            'verify_at' => now(),
            'queue_number' => $queueNumber
        ]);
        $deviceToken = User::where('id', $reservation->create_by)->pluck('device_token')->first();
        $titleNotificationTemplate = "Reservasi kamu sudah berhasil di verifikasi oleh " . $reservation->docter->name;
        FCM::android([$deviceToken])->send([
            'title' =>  $titleNotificationTemplate,
            'message' => "Jangan lupa datang tepat waktu yaa..!",
            'reservation_id' => $reservation->id,
        ]);


        return redirect()->route('reservations.index')->with('success', 'Success verify');
    }
    public function arrived($id)
    {
        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id', $id)->firstOrFail();
        if ($reservation->docter->id !== $idDocter) {
            return redirect()->route('reservations.index')->with('error', 'You not have access!');
        }
        $reservation->update([
            'status' => 'arrived',
            'time_arrival' => now()
        ]);
        return redirect()->route('reservations.index')->with('success', 'Success update this reservation!');
    }
    public function done($id)
    {

        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id', $id)->firstOrFail();
        if ($reservation->docter->id !== $idDocter) {
            return redirect()->route('reservations.index')->with('error', 'You not have access!');
        }
        $reservation->update([
            'status' => 'done',
            'done_at' => now()
        ]);
        return redirect()->route('reservations.index')->with('success', 'Success update this reservation!');
    }
    public function cancel (CancelReservationRequest $cancelReservationRequest, $id){
        $input = $cancelReservationRequest->only('remark_cancel');
        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id', $id)->firstOrFail();
        if ($reservation->docter->id !== $idDocter) {
            return redirect()->route('reservations.index')->with('error', 'You not have access!');
        }
        $input['status'] = 'cancel';
        $reservation->update($input);
        return redirect()->route('reservations.index')->with('success', 'Success cancel this reservation!');

    }
}
