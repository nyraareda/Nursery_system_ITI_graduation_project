<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'educational_qualification' => $this->educational_qualification,
            'job_title' => $this->job_title,
            'workplace' => $this->workplace,
            'work_phone' => $this->work_phone,
            'personal_phone' => $this->personal_phone,
            'address' => $this->address,
            'home_phone' => $this->home_phone,
            'street_number' => $this->street_number,
            'apartment_number' => $this->apartment_number,
            'children' => $this->children->map(function ($child) {
                return [
                    'full_name' => $child->full_name,
                    'birthdate' => $child->birthdate,
                    'place_of_birth' => $child->place_of_birth,
                    'gender' => $child->gender,
                ];
            }),
        ];
    }
}
