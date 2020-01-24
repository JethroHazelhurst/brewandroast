<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCafeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name'                    => 'required',
            'location.*.address'      => 'required',
            'location.*.city'         => 'required',
            'location.*.state'        => 'required',
            'location.*.zip'          => 'required',
            'location.*.brew_methods' => 'sometimes|array'
        ];
    }
}
