<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'status_id',
        'note',
        'is_active',
    ];


    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAllData($query)
    {
        return $query;
    }
    public function scopeExistRecord($query, $validatedData)
    {
        return $query->where('order_id', $validatedData['order_id'])->where('status_id', $validatedData['status_id']);
    }
    
}
