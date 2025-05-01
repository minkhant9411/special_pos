<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'is_deleted',
        'updated_by',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

}
