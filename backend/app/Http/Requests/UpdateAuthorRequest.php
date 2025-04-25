<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    public function authorize()
    {
        // Return true if the user is authorized to make this request
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ];
    }
}

