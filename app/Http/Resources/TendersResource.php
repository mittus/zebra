<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TendersResource extends JsonResource
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
            'code' => $this->code,
            'number' => $this->number,
            'status' => $this->status,
            'name' => $this->name,
            'date' => $this->date,
        ];
    }
}
