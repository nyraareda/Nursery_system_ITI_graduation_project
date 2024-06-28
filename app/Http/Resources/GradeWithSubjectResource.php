<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeWithSubjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'child_id' => $this->child_id,
            'subject_id' => $this->subject_id,
            'grade' => $this->grade,
            'subject' => [
                'id' => $this->subject->id,
               // 'class_id' => $this->subject->class_id,
                'level_id' => $this->subject->level_id,
                'subject_name' => $this->subject->subject_name,
                'description' => $this->subject->description,
            ]
        ];
    }
}


