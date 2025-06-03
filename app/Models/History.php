<?php

namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class History extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }
    //
}
