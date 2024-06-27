<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'title' => $this->title,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'parent' => [
                'id' => $this->parent->id,
                'first_name' => $this->parent->first_name,
                'last_name' => $this->parent->last_name,
                'job_title' => $this->parent->job_title,
                'address' => $this->parent->address,
                'personal_phone' => $this->parent->personal_phone,
                'user' => [
                    'email' => $this->parent->user->email,
                    'phone' => $this->parent->user->phone,
                    'username' => $this->parent->user->username,
                ],
            ],
        ];
    }
}
