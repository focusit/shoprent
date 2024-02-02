<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Hun',
            'email' => 'admin@shoprent.com',
            'password' => '$2a$12$tZIalU4Xb/3D29CeJXpHIOJZ9AXe/zX6vmWfY6vH6Ma7rreVV8WPS',
            'is_admin' => true,
        ]);
    }
}
