<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChildCurriculumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'child_id' => [
                'required',
                'exists:children,id',
                Rule::unique('child_curriculums')->where(function ($query) {
                    return $query->where('curriculum_id', $this->curriculum_id);
                }),
            ],
            'curriculum_id' => 'required|exists:curriculums,id',
        ];
    }

    public function messages()
    {
        return [
            'child_id.unique' => 'This child is already enrolled in a curriculum.',
        ];
    }
}
