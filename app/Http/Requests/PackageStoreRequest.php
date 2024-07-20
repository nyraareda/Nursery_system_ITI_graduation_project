<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PackageStoreRequest extends FormRequest
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
        $packageId = $this->route('package') ?? $this->route('id');

        $rules = [
            'name' => ['required', 'string', 'min:5', Rule::unique('packages')->ignore($packageId)],
            'advantages' => ['required', 'string', 'min:5'],
            'price' => ['required', 'numeric', 'between:0,9999999.99'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = ['sometimes', 'string', 'min:5', Rule::unique('packages')->ignore($packageId)];
            $rules['advantages'] = ['sometimes', 'string', 'min:5'];
            $rules['price'] = ['sometimes', 'numeric', 'between:0,9999999.99'];
        }

        return $rules;
    }
}
