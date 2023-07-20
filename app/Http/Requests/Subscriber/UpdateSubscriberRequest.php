<?php

namespace App\Http\Requests\Subscriber;

use App\Models\Subscriber;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'state' => [Rule::in([
                Subscriber::STATE_ACTIVE,
                Subscriber::STATE_UNSUBSCRIBED,
                Subscriber::STATE_JUNK,
                Subscriber::STATE_BOUNCE,
                Subscriber::STATE_UNCONFIRMED,
            ])],
        ];
    }
}
