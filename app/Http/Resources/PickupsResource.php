<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PickupsResource extends JsonResource
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
            'name' => $this->name,
            'car_name' => $this->car->name,
            'description' => $this->car->description,
            'price' => $this->car->price,
            'source_place' => $this->source->name,
            'source_place_id' => $this->source->id,
        ];
    }
}
