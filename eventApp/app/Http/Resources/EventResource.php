<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' =>$this->name,
            'description' =>$this->description,
            'location' =>$this->location,
            'starting_date' =>$this->starting_date,
            'ending_date'=>$this->ending_date,
            'organizer_id' => $this->organizer_id,
            'capacity' =>$this->capacity,
            'status' =>$this->status
        ];
    }
}
