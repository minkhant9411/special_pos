<?php

namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }

    protected $fillable = [
        'name',
        'image_path',
        'category_id',
        'description',
        'cost_price',
        'price',
        'unit',
        'created_by',
        'updated_by',
        'is_deleted',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'product_purchase')->withPivot(['price', 'quantity', 'id']);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'product_sale')->withPivot(['price', 'quantity', 'id']);
    }
}
