<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'bill_id',
        'amount',
        'payment_date',
        'payment_method',
        'status',
        'remark',
    ];

    protected $dates = ['payment_date'];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'id');
    }
}
