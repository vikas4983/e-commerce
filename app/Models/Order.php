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
    protected static function booted()
    {
        static::creating(function ($model) {
            if (is_null($model->user_id) && is_null($model->guest_token)) {
                $model->guest_token = (string) Str::uuid();
            }
        });
    }
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
