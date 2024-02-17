<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopRent;

class ShopRentSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            ShopRent::create([
                'shop_id' => 'Q' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'latitude' => '40.7128',
                'longitude' => '-74.0060',
                'address' => '123 Main St',
                'pincode' => '100001',
                'rent' => 1500,
                'status' => 'vaccant',
                'image' => '1703249535.jpg',
            ]);
        }
    }
}
