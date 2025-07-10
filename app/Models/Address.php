<?php

namespace App\Models;

use CountryList\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'guest_token',
        'type',
        'full_name',
        'address_line',
        'mobile',
        'postal_code',
        'country',
        'state',
        'city',
    ];

    public function scopeid($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query)
    {
        return $query;
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (is_null($model->user_id) && is_null($model->guest_token)) {
                $model->guest_token = (string) Str::uuid();
            }
        });
    }
    public function setCountryAttribute($value): void
    {
        if (!empty($value)) {
            $this->attributes['country'] = $value;
          
        } else {
            $ip = request()->ip();
            if ($ip === '127.0.0.1' || $ip === '::1') {
                $ip = '182.76.45.123';
            }
            $response = Http::get("http://ip-api.com/json/{$ip}");
            if ($response->ok() && $response->json('status') === 'success') {
                $countryName = $response->json('country');
                $country = Country::where('name', $countryName)->first();
                $this->attributes['country'] = $country->id ?? '101';
            }
        }
    }
}
