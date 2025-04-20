<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

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
        return $this->belongsToMany(Product::class);
    }
}
