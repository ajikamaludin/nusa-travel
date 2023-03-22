<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FastboatTracksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fastboat_id' => $this->group->fastboat->id,
            'fastboat' => $this->group->fastboat->name,
            'from_id' => $this->source->id,
            'from' => $this->source->name,
            'to_id' => $this->destination->id,
            'to' => $this->destination->name,
            'name' => $this->group->name,
            'arrival_time' => $this->arrival_time,
            'departure_time' => $this->departure_time,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'updated_at' => $this->updated_at->format('d-m-Y H:m'),
        ];
    }
}
