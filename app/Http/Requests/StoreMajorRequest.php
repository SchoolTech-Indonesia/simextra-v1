<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMajorRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atur ke false jika Anda memerlukan otorisasi
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:majors,name',
            'code' => 'nullable|string|max:50|unique:majors,code',
            'description' => 'nullable|string',

        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'The name has already been taken.',
            'code.unique' => 'The code has already been taken.',
        ];
    }
}
