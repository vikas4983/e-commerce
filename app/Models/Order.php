<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
       

        'user_id',
        'guest_token',
        'total_amount',
        'payment_status',
        'payment_method',
        'order_status',
        'is_active',
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
