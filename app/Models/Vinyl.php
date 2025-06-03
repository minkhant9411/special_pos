<?php

namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class Vinyl extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }

    protected $fillable = [
        'width',
        'length',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'vinyl_sale')->withPivot(['price', 'quantity', 'id']);
    }
}
