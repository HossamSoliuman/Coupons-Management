<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'code_id' => ['integer', 'exists:codes,id', 'required'],
            'shop_id' => ['integer', 'exists:shops,id', 'required'],
            'name' => ['string', 'max:255', 'required'],
            'amount' => ['string', 'max:255', 'required'],
            'max_usage_times' => ['integer', 'required'],
            'is_code_page' => 'nullable',
        ];
    }
}
