<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'guest_token',
        'product_id',
        'variant_id',
        'quantity',
    ];
    public function scopeid($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query)
    {
        return $query;
    }
    public function setGuestTokenAttribute($value): void
    {
        $this->attributes['guest_token'] = Str::uuid();
    }
}
