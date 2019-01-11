<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'name' => 'required|max:255',
            'latitude' => 'required|numeric|min:1',
            'longitude' => 'required|numeric|min:1',
            'street' => 'required',
            'fuel_types.*.price' => 'nullable|numeric|max:1000',
        ];
    }

    /**
     * Change error messages
     *
     * @return array
     */
    public function messages() {
        return [
            'fuel_types.*.price.max'=>'The fuel type must be less than 1000',
            'fuel_types.*.price.numeric'=>'The fuel type must be number'
        ];
    }
}
