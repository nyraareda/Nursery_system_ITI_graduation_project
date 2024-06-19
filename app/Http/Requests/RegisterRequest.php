<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'username' => 'nullable|string|between:2,100|unique:users,username',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string|min:10|max:15|unique:users,phone',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a string.',
            'username.between' => 'Username must be between :min and :max characters.',
            'username.unique' => 'Username is already taken.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email must not exceed :max characters.',
            'email.unique' => 'Email is already registered.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least :min characters.',
            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.min' => 'Phone number must be at least :min characters.',
            'phone.max' => 'Phone number must not exceed :max characters.',
            'phone.unique' => 'Phone number is already registered.',
        ];
    }
}
