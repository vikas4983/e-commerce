<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'attribute',
        'value',
        'price',
        'stock',
        'is_active'
    ];

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query)
    {
        return $query;
    }
}
