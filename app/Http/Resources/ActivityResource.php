<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'class_id' => $this->class_id,
            'child_id' => $this->child_id,
            'activity_name' => $this->activity_name,
            'description' => $this->description,
        ];
    }
}
