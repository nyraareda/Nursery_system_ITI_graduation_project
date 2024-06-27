<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_id' => 'required|exists:parents,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ];
    }
}
