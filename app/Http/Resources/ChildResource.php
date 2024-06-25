<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
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
            'full_name' => $this->full_name,
            'birthdate' => $this->birthdate,
            'place_of_birth' => $this->place_of_birth,
            'gender' => $this->gender,
            'photo' => $this->photo,
            'current_residence' => $this->current_residence,
           
        ];
    }
}
