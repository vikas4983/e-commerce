<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
    protected static function booted()
    {
        static::creating(function ($model) {
            if (is_null($model->user_id) && is_null($model->guest_token)) {
                $model->guest_token = (string) Str::uuid();
            }
        });
    }
    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query)
    {
        return $query;
    }
}
