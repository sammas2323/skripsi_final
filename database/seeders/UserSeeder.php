<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'admin@gmail.com', 'status'  => 'active', 'role' => 'admin', 'password' => '231231']);
        User::create(['name' => 'customer', 'email' => 'customer@gmail.com', 'status'  => 'active', 'role' => 'customer', 'password' => '231231']);
    }
}
