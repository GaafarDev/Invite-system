<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
           // Clear the users table
           User::truncate();
           
        User::create([
            'fullname' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'gender' => 'male',
            'password' => bcrypt('password'),
            'remember_token' => \Str::random(10),
        ]);

        User::create([
            'fullname' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'gender' => 'female',
            'password' => bcrypt('password'),
            'remember_token' => \Str::random(10),
        ]);
    }
}

