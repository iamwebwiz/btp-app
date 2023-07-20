<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes;

    const STATE_ACTIVE = 'active';
    const STATE_UNSUBSCRIBED = 'unsubscribed';
    const STATE_JUNK = 'junk';
    const STATE_BOUNCE = 'bounced';
    const STATE_UNCONFIRMED = 'unconfirmed';

    const SOURCE_API = 'api';
    const SOURCE_WEB = 'web';
    const SOURCE_FORMS = 'forms';
    const SOURCE_IOS = 'ios';

    protected $fillable = ['email', 'name', 'state', 'source'];

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('value');
    }
}
