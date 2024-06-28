<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
                        'id' => $this->id,
                        'activity_name' => $this->activity_name,
                        'description' => $this->description,
                        'child_id' => $this->child_id,
                        'child_name' => $this->child->full_name,
                        'child' => new ChildResource($this->whenLoaded('child')),
                    ];
    }
}
