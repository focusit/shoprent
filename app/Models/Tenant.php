<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $primaryKey = 'tenant_id';
    public $incrementing = false;

    protected $fillable = [
        'tenant_id',
        'govt_id',
        'image',
        'address',
        'pincode',
        'email',
        'full_name',
        'govt_id_number',
        'gst_number',
        'contact',
        'password',
    ];

    public function shopRents()
    {
        return $this->hasMany(ShopRent::class, 'tenant_id', 'tenant_id');
    }
    public function bills()
    {
        return $this->hasMany(Bill::class, 'tenant_id', 'tenant_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
