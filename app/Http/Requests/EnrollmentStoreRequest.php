<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
                'class_id' => ['required', 'exists:class,id'],
                'description' => ['required', 'string','min:5'],
                'status' => ['required', 'in:active, completed, dropped'],
            ];

            if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
                $rules['child_id'] = ['sometimes', 'nullable', 'exists:child,id'];
                $rules['status'] = ['sometimes', 'nullable', 'in:active, completed, dropped'];
            }
    
            return $rules;
    }
}
