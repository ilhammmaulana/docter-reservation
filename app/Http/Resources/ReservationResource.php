<?php

namespace App\Http\Resources;

use App\Http\Resources\API\DocterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'time_reservation' => $this->time_reservation,
            'time_arrival' => $this->time_arrival,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'docter_id' => $this->docter_id,
            'created_by' => $this->created_by,
            'queue_number' => $this->queue_number,
            'remark_cancel' => $this->remark_cancel,
            'docter' => new DocterResource($this->docter),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
      
    }
}
