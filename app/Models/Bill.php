<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Bill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agreement_id',
        'shop_id',
        'tenant_id',
        'shop_address',
        'tenant_full_name',
        'rent',
        'payment_date',
        'due_date',
        'penalty',
        'discount',
        'status'
    ];

    /**
     * Get billing settings from the JSON file.
     *
     * @return array
     */
    public static function getBillingSettings()
    {
        $jsonFilePath = storage_path('app/billing_settings.json');

        if (File::exists($jsonFilePath)) {
            return json_decode(File::get($jsonFilePath), true);
        }
        return [];
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function shop()
    {
        return $this->belongsTo(ShopRent::class, 'shop_id');
    }
}
