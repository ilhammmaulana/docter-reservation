<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class DocterResource extends JsonResource
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
            "id" => $this->id,
            "photo" => $this->photo === null ? null : url($this->photo),
            "images" => DocterImageResource::collection($this->images),
            "name" => $this->name,
            "address" => $this->address,
            "category" => $this->category,
            "subdistrict" => new SubdistrictResource($this->subdistrict),
        ];
    }
}
