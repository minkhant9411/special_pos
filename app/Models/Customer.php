<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
