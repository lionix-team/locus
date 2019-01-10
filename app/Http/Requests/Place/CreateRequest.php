<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'photo' => 'required',
        ];
    }
}
