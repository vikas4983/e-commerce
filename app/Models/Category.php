<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = Str::lower(trim($value));
        $this->attributes['slug'] = Str::slug($value);
    }
    public function scopeid($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query)
    {
        return $query;
    }
}
