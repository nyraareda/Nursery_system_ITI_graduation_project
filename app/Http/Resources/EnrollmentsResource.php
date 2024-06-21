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
            'class_id' => $this->class_id,
            'description'=> $this->description,
            'Child_enrolled' => new ChildResource($this->child),
            'date_enrolled' => $this->date_enrolled,
            'status'=> $this->status,
        ];
    }
}
