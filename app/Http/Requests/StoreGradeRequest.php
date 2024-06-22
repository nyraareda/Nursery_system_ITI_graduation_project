<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set this to false if you need authorization logic
    }

    public function rules()
    {
        return [
            'child_id' => 'required|integer|exists:children,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:100',
        ];
    }
}
