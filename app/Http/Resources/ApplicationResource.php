<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status'=> $this->status,
            'date_submitted' => $this->date_submitted->format('Y-m-d H:i:s'),
            'Child_app' => new ChildResource($this->child),
        ];
    }
}
