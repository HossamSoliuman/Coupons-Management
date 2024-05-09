<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $codeId = $this->route('code')->id;

        return [
            'name' => [
                'string',
                'max:255',
                'nullable',
                Rule::unique('codes')->ignore($codeId),
            ],
            'unit_cost' => ['numeric', 'nullable'],
        ];
    }
}
