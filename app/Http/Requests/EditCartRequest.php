<?php

namespace App\Http\Requests;

use App\Exceptions\FailedValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EditCartRequest extends FormRequest
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
            'product_id' => 'required | numeric | min:0'
        ];
    }
    
    public function messages()
    {
        return [
            'product_id.required' => 'وارد کردن ایدی محصول الزامی است',
            'product_id.min' => 'آیدی محصول باید عددی باشد',
            'product_id.numeric' => 'آیدی محصول باید بزرگتر از صفر باشد'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new FailedValidationException($validator->errors());
    }
}
