<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;

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
                'pincode' => '200002',
                'email' => 'tenant' . $i . '@example.com',
                'full_name' => 'John Doe ' . $i,
                'govt_id_number' => 'A' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'contact' => '6375397813' . $i,
                'password' => bcrypt('password123'),
            ]);
            User::create([
                'name' => 'John Doe ' . $i,
                'email' => 'tenant' . $i . '@example.com',
                'password' =>  bcrypt('admin'),
                'is_admin' => 0,
            ]);
        }
    }
}
