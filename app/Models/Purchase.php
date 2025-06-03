<?php

namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class Purchase extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }
    protected $fillable = [
        'voucher_id',
        'date',
        'description',
        'paid',
        'supplier_id',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['price', 'quantity', 'id']);
    }
}
