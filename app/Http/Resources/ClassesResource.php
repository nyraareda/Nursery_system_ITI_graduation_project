<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'curriculum_id' => $this->curriculum_id,
            'class_name' => $this->class_name,
            'description' => $this->description,
            'children' => ChildResource::collection($this->whenLoaded('children')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
