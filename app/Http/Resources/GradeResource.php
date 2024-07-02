<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'child_id' => $this->child_id,
            'subject_id' => $this->subject_id,
            'grade' => $this->grade,
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'created_at' => $this->created_at->toDateTimeString()

        ];
    }
}
