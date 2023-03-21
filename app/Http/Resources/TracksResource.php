<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TracksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'fastboat' => $this->group?->fastboat?->name,
            'from' => $this->destination?->name,
            'to' => $this->source?->name,
            'destination' => $this->group?->name,
            'arrival_time' => $this->arrival_time,
            'departure_time' => $this->departure_time,
            'price' => $this->price,
            'capacity' => $this->group?->fastboat?->capacity,
        ];
    }
}
