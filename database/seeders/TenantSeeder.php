<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            Tenant::create([
                'tenant_id' => 'T' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'govt_id' => 'A' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'image' => '1702127445.jpg',
                'address' => '456 Oak St',
                'pincode' => '20002',
                'email' => 'tenant' . $i . '@example.com',
                'full_name' => 'John Doe ' . $i,
                'govt_id_number' => 'A' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'contact' => '123-456-789' . $i,
                'password' => bcrypt('password123'),
            ]);
        }
    }
}
