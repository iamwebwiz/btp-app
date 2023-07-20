<?php

namespace App\Http\Requests\Field;

use App\Models\Field;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateFieldRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|unique:fields',
            'type' => ['required', 'string', Rule::in([
                Field::TYPE_STRING,
                Field::TYPE_NUMBER,
                Field::TYPE_BOOLEAN,
                Field::TYPE_DATE,
            ])],
        ];
    }
}
