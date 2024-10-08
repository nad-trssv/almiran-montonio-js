<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => [
                'required',
                'string',
                'max:190',
                Rule::unique("product_attributes", "name")->ignore($this->route('productAttribute.id'))
            ],
            'name_et'        => [
                'nullable',
                'string',
                'max:190',
                Rule::unique("product_attributes", "name_et")->ignore($this->route('productAttribute.id'))
            ],
            'name_ru'        => [
                'nullable',
                'string',
                'max:190',
                Rule::unique("product_attributes", "name_ru")->ignore($this->route('productAttribute.id'))
            ],
        ];
    }
}
