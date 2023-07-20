<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FieldSubscriber extends Pivot
{
    protected $fillable = ['field_id', 'subscriber_id', 'value'];

    public $timestamps = false;
}
