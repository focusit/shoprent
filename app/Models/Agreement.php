<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'shop_id',
        'tenant_id',
        'with_effect_from',
        'valid_till',
        'rent',
        'status',
        'remark',
        'document_field',
    ];

    // Define relationships if needed
    public function shop()
    {
        return $this->belongsTo(ShopRent::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
