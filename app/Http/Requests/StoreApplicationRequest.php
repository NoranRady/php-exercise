<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreApplicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'start_date' => 'required|date|before_or_equal:end_date|before_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:today',
            'email' => 'required|email'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => 'Invalid Input',
            'messages' => $validator->errors(),
        ], 422));
    }

    public function messages(): array
    {

        return [
            'company_id.required' => 'The company id field is required.',
            'company_id.exists' => 'The selected company id is invalid.',
            'start_date.required' => 'The start date field is required.', 
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.before_or_equal' => 'The start date must be before or equal to the end date & today.',
            'end_date.required' => 'The end date field is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'start_date.before_or_equal' => 'The start date must be before or equal to today.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.'
        ];
    }
}
