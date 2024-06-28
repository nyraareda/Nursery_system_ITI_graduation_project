<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChildStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $rules = [
            'parent_id' => ['required', 'exists:parents,id'],
            'full_name' => ['required', 'string', 'min:3',Rule::unique('children')->ignore($this->child)],
            'birthdate' => ['required', 'date_format:Y-m-d'],
            'place_of_birth' => ['required', 'string', 'min:3'],
            'gender' => ['required', 'in:male,female,other'],
            'current_residence' => ['required', 'string', 'min:3'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            //'class_id' => 'sometimes|nullable|integer|exists:classes,id',
            'curriculum_id' => 'nullable|integer|exists:curriculums,id',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['parent_id'] = ['sometimes', 'nullable', 'exists:parents,id'];
            $rules['full_name'] = ['sometimes', 'nullable', 'string', 'min:3'];
            $rules['birthdate'] = ['sometimes', 'nullable', 'date_format:Y-m-d'];
            $rules['place_of_birth'] = ['sometimes', 'nullable', 'string', 'min:3'];
            $rules['gender'] = ['sometimes', 'nullable', 'in:male,female,other'];
            $rules['current_residence'] = ['sometimes', 'nullable', 'string', 'min:3'];
            $rules['photo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
          //  $rules['class_id'] = ['sometimes', 'nullable', 'exists:classes,id']; // Make class_id optional for updates
            $rules['curriculum_id'] = ['sometimes', 'nullable', 'exists:curriculums,id']; // Make curriculum_id optional for updates
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'parent_id.required' => 'The parent ID field is required.',
            'parent_id.exists' => 'The selected parent ID does not exist.',
            'full_name.required' => 'The full name field is required.',
            'birthdate.required' => 'The birthdate field is required.',
            'birthdate.date_format' => 'The birthdate must be in the format YYYY-MM-DD.',
            'gender.required' => 'The gender field is required.',
            'gender.in' => 'The gender field must be one of: male, female, other.',
            'current_residence.required' => 'The current residence field is required.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, jpg, gif.',
            'photo.max' => 'The photo may not be greater than :max kilobytes in size.',
            //'class_id.required' => 'The class ID field is required.',
            //'class_id.exists' => 'The selected class ID does not exist.',
            'curriculum_id.required' => 'The curriculum ID field is required.',
            'curriculum_id.exists' => 'The selected curriculum ID does not exist.',
        ];
    }
}
