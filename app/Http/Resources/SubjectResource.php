<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'class_id' => $this->class_id,
            'level_id' => $this->level_id,
            'subject_name' => $this->subject_name,
            'description' => $this->description,
            'grades' => GradeResource::collection($this->whenLoaded('grades')),
        ];
    }
}
