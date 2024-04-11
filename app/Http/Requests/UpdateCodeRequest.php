<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255', 'nullable'],
            'shop_id' => ['integer', 'exists:shops,id', 'nullable'],
            'is_shop_page' => 'nullable',
            'unit_cost' => ['string', 'nullable'],

        ];
    }
}
