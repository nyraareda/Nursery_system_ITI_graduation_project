<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeStoreRequest extends FormRequest
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
            'description' => ['required', 'string','min:5'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'in:paid,unpaid'],
        ];

        // If the request is for updating, make some fields nullable
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['child_id'] = ['sometimes', 'nullable', 'exists:children,id'];
            $rules['status'] = ['sometimes', 'nullable', 'in:paid,unpaid'];
        }

        return $rules;
    
    }
    
}
