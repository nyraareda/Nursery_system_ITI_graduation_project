<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurriculumRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set this to false if you need authorization logic
    }

    public function rules()
    {
        return [
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
