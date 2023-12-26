<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'tenant_id',
        'bill_amount',
        'due_date',
        'status',
        'paid_at',
    ];

    protected $dates = [
        'due_date',
        'paid_at',
    ];

    public function shop()
    {
        return $this->belongsTo(ShopRent::class, 'shop_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    // Add more relationships or methods as needed
}
