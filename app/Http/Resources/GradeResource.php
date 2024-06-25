<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'child_id' => $this->child_id,
            'subject_id' => $this->subject_id,
            'grade' => $this->grade,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // 'child' => new ChildResource($this->whenLoaded('child')),
            // 'subject' => new SubjectResource($this->whenLoaded('subject')),
        ];
    }
}
