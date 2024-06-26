<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'payment_date',
        'previous_balance',
        'payment_method',
        'status',
        'remark',
        'transaction_number',
        'tenant_id',
    ];

    protected $dates = ['payment_date'];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
