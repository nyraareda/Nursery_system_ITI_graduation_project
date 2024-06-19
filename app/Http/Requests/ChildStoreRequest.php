<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildStoreRequest extends FormRequest
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
            'parent_id' => ['required', 'exists:parents,id'],
            'full_name' => ['required', 'string', 'min:3'],
            'birthdate' => ['required', 'date_format:Y-m-d'],
            'place_of_birth' => ['required', 'string', 'min:3'],
            'gender' => ['required', 'in:male,female,other'],
            'current_residence' => ['required', 'string', 'min:3'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];

        // If the request is for updating, make some fields nullable
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['parent_id'] = ['sometimes', 'nullable', 'exists:parents,id'];
            $rules['full_name'] = ['sometimes', 'nullable', 'string', 'min:3'];
            $rules['birthdate'] = ['sometimes', 'nullable', 'date_format:Y-m-d'];
            $rules['place_of_birth'] = ['sometimes', 'nullable', 'string', 'min:3'];
            $rules['gender'] = ['sometimes', 'nullable', 'in:male,female,other'];
            $rules['current_residence'] = ['sometimes', 'nullable', 'string', 'min:3'];
            $rules['photo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'parent_id.required' => 'The parent ID field is required.',
            'parent_id.exists' => 'The selected parent ID is not exist.',
            'full_name.required' => 'The full name field is required.',
            'birthdate.required' => 'birthdate field is required.',
            'birthdate.date_format' => 'The birthdate must be in the format YYYY-MM-DD.',
            'gender.required' => 'gender field is required.',
            'gender.in' => 'The gender field must be one of: male, female, other.',
            'current_residence.required' => 'current_residence field is required.',
            'photo.required' => 'photo field is required.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, jpg, gif.',
            'photo.max' => 'The photo may not be greater than :max kilobytes in size.',
        ];
    }
}