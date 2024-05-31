<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'code_id' => ['integer', 'exists:codes,id', 'nullable'],
            'shop_id' => ['integer', 'exists:shops,id', 'nullable'],
            'name' => ['string', 'max:255', 'nullable'],
            'amount' => ['string', 'max:255', 'nullable'],
            'max_usage_times' => ['integer', 'nullable'],
            'page' => 'nullable',
        ];
    }
}
