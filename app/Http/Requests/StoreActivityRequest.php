<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'class_id' => 'required|integer|exists:classes,id',
            'activity_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
