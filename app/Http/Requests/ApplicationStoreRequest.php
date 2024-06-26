<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'child_id' => ['required', 'exists:children,id'],
            'status' => 'required|in:pending,accepted,rejected',        ];

        // If the request is for updating, make some fields nullable
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['child_id'] = ['sometimes', 'nullable', 'exists:child,id'];
            $rules['status'] = ['sometimes', 'nullable', 'in:pending,accepted,rejected'];
        }

        return $rules;
    
    }
}
