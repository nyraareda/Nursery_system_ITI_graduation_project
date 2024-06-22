<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassesRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set this to false if you need authorization logic
    }

    public function rules()
    {
        return [
            'curriculum_id' => 'required|integer|exists:curriculums,id',
            'class_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
