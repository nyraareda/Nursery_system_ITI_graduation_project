<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            
            'id'=>$this->id,
            'description'=>$this->description,
            'amount'=>$this->amount,
            'status'=>$this->status,
            'due_date'=>$this->due_date,
            'date_paid'=>$this->date_paid,
            // 'child-fees'=>new ChildResource($this->child),
        ];
    }
}
