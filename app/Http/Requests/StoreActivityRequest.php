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
            
                'child_id' => 'nullable|integer|exists:children,id',
                'activity_name' => 'required|string|max:255',
                'description' => 'nullable|string',


        ];
    }
}
