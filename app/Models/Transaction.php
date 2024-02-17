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
        'property_type',
        'tenant_name',
        'type',
        'remarks',
    ];
}
