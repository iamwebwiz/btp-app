<?php

namespace App\Http\Requests\Subscriber;

use App\Models\Subscriber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSubscriberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns|unique:subscribers',
            'name' => 'required|string|min:3',
            'source' => ['required', Rule::in([
                Subscriber::SOURCE_API,
                Subscriber::SOURCE_FORMS,
                Subscriber::SOURCE_IOS,
                Subscriber::SOURCE_WEB,
            ])],
        ];
    }
}
