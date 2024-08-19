<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
            'name' => 'Administrator',
            'email' => 'administrator@softdroid.com',
            'password' => Hash::make('Securedkey@2024'),
            'role' => 'superadminstrator',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'email' => 'user@softdroid.com',
                'password' => Hash::make('Securedkey@2024'),
                'role' => 'admin',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
