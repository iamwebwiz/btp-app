<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;

class AddFieldsToSubscriberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fields' => 'array',
            'fields.*.field_id' => 'required|exists:fields,id',
        ];
    }
}
