<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::create([
            'name' =>"maruf",
            'email' => "maruf@gmail.com",
            'password' => "12345678",
            'slug' => 1,
        ]);
        User::create([
            'name' =>"tasnim",
            'email' => "tasnim@gmail.com",
            'password' => "12345678",
            'slug' => 2,
        ]);
        User::create([
            'name' =>"jawad",
            'email' => "jawad@gmail.com",
            'password' => "12345678",
            'slug' => 3,
        ]);
    }
}
