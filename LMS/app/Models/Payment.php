<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'payment_id',
        'amount',
        'currency',
        'status'
    ];

    protected $casts = [
        'amount' =>  'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayAmountAttribute()
    {
        return $this->amount / 100; // Returns 123.00 for 12300
    }

    public function getFormattedAmountAttribute()
    {
        return  number_format($this->amount / 100, 2);
    }
}