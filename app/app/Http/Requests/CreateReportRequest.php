<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReportRequest extends FormRequest
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
            'shelter_id' => 'required|integer|exists:shelters,id',
            'location' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'animal_status' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
        ];
    }
}
