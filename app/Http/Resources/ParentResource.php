<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'job_title' => $this->job_title,
            'address' => $this->address,
            // 'educational_qualification' => $this->educational_qualification,
            // 'workplace' => $this->workplace,
            // 'work_phone' => $this->work_phone,
            // 'personal_phone' => $this->personal_phone,
            // 'home_phone' => $this->home_phone,
            // 'street_number' => $this->street_number,
            // 'apartment_number' => $this->apartment_number,
        ];
    }
}
