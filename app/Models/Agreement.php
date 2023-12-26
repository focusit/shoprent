<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $primaryKey = 'agreement_id';
    public $incrementing = false;
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

    public function shopRents()
    {
        return $this->hasMany(ShopRent::class, 'agreement_id', 'agreement_id');
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
