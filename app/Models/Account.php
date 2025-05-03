<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'description',
        'type',
        'amount',
        'stuff_id',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];
    public function stuff()
    {
        return $this->belongsTo(Stuff::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
