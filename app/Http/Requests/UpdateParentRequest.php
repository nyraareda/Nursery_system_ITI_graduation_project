<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'educational_qualification' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'workplace' => 'required|string|max:255',
            'work_phone' => 'required|string|max:15',
            'personal_phone' => 'required|string|max:15',
            'address' => 'required|string',
            'home_phone' => 'required|string|max:15',
            'street_number' => 'required|string|max:10',
            'apartment_number' => 'required|string|max:10',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user does not exist.',
            'first_name.required' => 'The first name is required.',
            'first_name.max' => 'The first name may not be greater than 255 characters.',
            'last_name.required' => 'The last name is required.',
            'last_name.max' => 'The last name may not be greater than 255 characters.',
            'educational_qualification.required' => 'The educational qualification is required.',
            'educational_qualification.max' => 'The educational qualification may not be greater than 255 characters.',
            'job_title.required' => 'The job title is required.',
            'job_title.max' => 'The job title may not be greater than 255 characters.',
            'workplace.required' => 'The workplace is required.',
            'workplace.max' => 'The workplace may not be greater than 255 characters.',
            'work_phone.required' => 'The work phone is required.',
            'work_phone.max' => 'The work phone may not be greater than 15 characters.',
            'personal_phone.required' => 'The personal phone is required.',
            'personal_phone.max' => 'The personal phone may not be greater than 15 characters.',
            'address.required' => 'The address is required.',
            'home_phone.required' => 'The home phone is required.',
            'home_phone.max' => 'The home phone may not be greater than 15 characters.',
            'street_number.required' => 'The street number is required.',
            'street_number.max' => 'The street number may not be greater than 10 characters.',
            'apartment_number.required' => 'The apartment number is required.',
            'apartment_number.max' => 'The apartment number may not be greater than 10 characters.',
        ];
    }
}