<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'payment_method',
        'agreement_id',
        'shop_id',
        'bill_no',
        'amount',
        'tenant_id',
        'tenant_name',
        'type',
        'remarks',
        'user_id',
        'G8',
        'reconciled_by',
    ];
    public function bills()
    {
        return $this->hasMany(Bill::class)->onDelete('cascade');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->onDelete('cascade');
    }
}
