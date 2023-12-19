<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRent extends Model
{
    use HasFactory;

    protected $primaryKey = 'shop_id';

    protected $fillable = [
        'shop_id',
        'latitude',
        'longitude',
        'address',
        'pincode',
        'rent',
        'status',
        'image',
        'tenant_id'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
    public function allocateToTenant($tenantId)
    {
        // Update the shop status, or any other logic as needed
        $this->status = 'occupied';

        // Check if the shop has a tenant relationship
        if ($this->tenant_id) {
            return;
        }

        // Associate the tenant with the shop
        $this->tenant_id = $tenantId;
        // Save changes
        $this->save();
    }
}
