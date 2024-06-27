<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentsResource extends JsonResource
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
            'description' => $this->description,
            // 'date_enrolled' => $this->date_enrolled,
            'status' => $this->status,
            'child' => new ChildResource($this->whenLoaded('child')),
            'subjects' =>new SubjectResource($this->whenLoaded('subjects')),
        ];
    }
}
