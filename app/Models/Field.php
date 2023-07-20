<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_DATE = 'date';
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';
    const TYPE_BOOLEAN = 'boolean';

    protected $fillable = ['title', 'type'];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class)->withPivot('value');
    }
}
