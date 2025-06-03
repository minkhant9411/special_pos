<?php

namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class Sale extends Model
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
        'customer_id',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['price', 'quantity', 'id']);
    }
    public function vinyls()
    {
        return $this->belongsToMany(Vinyl::class, 'vinyl_sale')->withPivot(['price', 'quantity', 'id'])->withTimestamps();
    }
    public function boards()
    {
        return $this->belongsToMany(Board::class, 'board_sale')->withPivot(['price', 'quantity', 'id'])->withTimestamps();
    }
}
