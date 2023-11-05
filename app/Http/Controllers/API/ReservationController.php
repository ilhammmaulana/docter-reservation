<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->requestSuccessData(ReservationResource::collection(ReservationRepository::getReservation($this->guard()->id())));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReservationRequest $createReservationRequest)
    {
        try {
            $input = $createReservationRequest->only("docter_id", "remarks", "time_reservation");
            $input['time_reservation'] = Carbon::parse($input['time_reservation'])->toDateTimeString();
            $input['created_by'] = $this->guard()->id();
            $today = now()->startOfDay();
            $reservationCount = Reservation::where('created_by', $input['created_by'])->where('docter_id', $input['docter_id'])->whereDate('created_at', $today)->count();
            if ($reservationCount > 0) {
                return $this->badRequest('allready_reservation', 'You allready reservation!');
            }

            ReservationRepository::createReservation($input);
            return $this->requestSuccess();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
