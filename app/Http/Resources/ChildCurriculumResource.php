<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildCurriculumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'child_id' => $this->child_id,
            'curriculum_id' => $this->curriculum_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'child' =>  ChildwithParentResource::collection($this->whenLoaded('child')),
            'grades' => GradeResource::collection($this->whenLoaded('grades')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects'))
        ];
    }
}
