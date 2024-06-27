<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_id' => 'sometimes|exists:parents,id',
            'title' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
        ];
    }
}
