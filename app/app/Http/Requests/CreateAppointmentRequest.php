<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
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
            'name' => ['required', 'unique:adopters,name,'.$this->id],
            'phone' => ['required', 'unique:adopters,phone,'.$this->id],
            'email' => ['required', 'email' ,'unique:adopters,email,'.$this->id],
            'appointment_date' => ['required']
        ];
    }
}
