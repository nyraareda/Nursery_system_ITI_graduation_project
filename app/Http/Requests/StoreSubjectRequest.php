<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

                'curriculum_id' => 'required|exists:curriculums,id',
                'subject_name' => 'required|string|max:255',
                'description' => 'nullable|string',
        ];
    }
}
