<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'shelter_id' => ['required'],
            'name' => ['required', 'string', 'unique:users,name'],
            'username' => ['required', 'string', 'unique:users,username'],
            'password' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'shelter_id.required' => 'Shelter field is required'
        ];
    }
}
