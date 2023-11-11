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
        $deviceToken = User::where('id', $reservation->created_by)->pluck('device_token')->first();
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

       try {
        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id', $id)->firstOrFail();
        if ($reservation->docter->id !== $idDocter) {
            return redirect()->route('reservations.index')->with('error', 'You not have access!');
        }
        $deviceToken = User::where('id', $reservation->created_by)->pluck('device_token')->first();
        $titleNotificationTemplate = "Reservasi ke " . $reservation->docter->name . " mu sudah selesai";
        FCM::android([$deviceToken])->send([
            'title' =>  $titleNotificationTemplate,
            'message' => "Trimakasih telah reservasi!",
            'reservation_id' => $reservation->id,
        ]);
        $reservation->update([
            'status' => 'done',
            'done_at' => now()
        ]);
        return redirect()->route('reservations.index')->with('success', 'Success update this reservation!');
       } catch (\Throwable $th) {
        throw $th;
       }
    }
    public function cancel (CancelReservationRequest $cancelReservationRequest, $id){
        $input = $cancelReservationRequest->only('remark_cancel');
        $idDocter = getDataUser()->id;
        $reservation = Reservation::with('docter')->where('id', $id)->firstOrFail();
        $deviceToken = User::where('id', $reservation->created_by)->pluck('device_token')->first();
        $titleNotificationTemplate = "Maaf dokter" . $reservation->docter->name . " mengcancel reservasi mu karena hal tertentu";
        FCM::android([$deviceToken])->send([
            'title' =>  $titleNotificationTemplate,
            'message' => "Check ke aplikasi untuk tahu kenapa docter cancel reservasi mu!",
            'reservation_id' => $reservation->id,
        ]);
        if ($reservation->docter->id !== $idDocter) {
            return redirect()->route('reservations.index')->with('error', 'You not have access!');
        }
        $input['status'] = 'cancel';
        $reservation->update($input);
        return redirect()->route('reservations.index')->with('success', 'Success cancel this reservation!');

    }
    public function history()
    {
        return view('pages.reservations-history', [
            'reservations' => ReservationRepository::getHistoryReservation(getDataUser()->id)
        ]);    
    }
}
