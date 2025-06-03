<?php

namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }

    protected $fillable = [
        'name',
        'description',
        'transaction_type',
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
