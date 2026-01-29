<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = Str::lower(trim($value));
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
