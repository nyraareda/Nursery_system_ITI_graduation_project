<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildwithParentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'birthdate' => $this->birthdate,
            'place_of_birth' => $this->place_of_birth,
            'gender' => $this->gender,
            'photo' => $this->photo,
            'current_residence' => $this->current_residence,
            'class_name' => optional($this->subjects->first())->name,
            'level' => optional($this->subjects->first())->level,
            'parent' => [
                'id' => $this->parent->id,
                'first_name' => $this->parent->first_name,
                'last_name' => $this->parent->last_name,
                'job_title' => $this->parent->job_title,
                'address' => $this->parent->address,
                'personal_phone' => $this->parent->user->phone,
                'user' => [
                    'email' => $this->parent->user->email,
                    'phone' => $this->parent->user->phone,
                ]
            ],
            'application' => [
                'id' => optional($this->applications->first())->id,
                'status' => optional($this->applications->first())->status,
                'date_submitted' => optional($this->applications->first())->date_submitted,
            ],
            'grades' => GradeResource::collection($this->grades),
            'subjects' => SubjectResource::collection($this->subjects)
        ];
    }
}
