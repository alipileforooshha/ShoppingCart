<?php

namespace App\Http\Requests;

use App\Exceptions\FailedValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required | unique:products,name',
            'stock' => 'required | numeric',
            'price' => 'required | numeric | min : 0'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام محصول الزامی است',
            'name.unique' => 'نام محصول نمیتواند تکراری باشد',
            'price.required' => 'وارد کردن قیمت محصول الزامی است',
            'price.numeric' => 'قیمت محصول باید عددی باشد',
            'price.min' => 'قیمت محصول نمیتواند منفی باشد',
            'stock.numeric' => 'تعداد موجودی محصول باید عددی باشد',
            'stock.required' => 'وارد کردن تعداد موجودی محصول الزامی است',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new FailedValidationException($validator->errors());
    }
}
