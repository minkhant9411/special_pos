<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
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
        return $this->belongsToMany(Sale::class, 'board_sale')->withPivot(['price', 'quantity', 'id']);
    }
}
