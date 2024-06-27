<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject_name' => $this->subject_name,
            'description' => $this->description,
            'curriculum' => new CurriculumResource($this->whenLoaded('curriculum')),
        ];
    }
}
