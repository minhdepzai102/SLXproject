<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'active' => 'required|boolean'
        ];
    }

    public function authorize()
    {
        return true; // Ensure this is true to allow the request
    }
}
