<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'stock',
        'description',
        'image',
        'is_active',
    ];
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = Str::lower(trim($value));
        $this->attributes['slug'] = Str::slug($value);
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query){
       return $query;
    }
}
