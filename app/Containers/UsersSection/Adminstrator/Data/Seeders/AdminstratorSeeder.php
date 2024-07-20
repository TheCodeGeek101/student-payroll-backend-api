<?php


namespace App\Containers\UsersSection\Adminstrator\Data\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administrators')->insert([
            [
                'full_name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone_number' => '1234567890',
                'date_of_birth' => '1980-01-01',
                'gender' => 'Male',
                'street' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'Anystate',
                'postal_code' => '12345',
                'country' => 'USA',
                'employee_id' => 'EMP001',
                'date_of_hire' => '2010-01-01',
                'password' => Hash::make('password'), // Assuming you store hashed passwords
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'phone_number' => '2345678901',
                'date_of_birth' => '1985-02-02',
                'gender' => 'Female',
                'street' => '456 Oak St',
                'city' => 'Somecity',
                'state' => 'Somestate',
                'postal_code' => '23456',
                'country' => 'USA',
                'employee_id' => 'EMP002',
                'date_of_hire' => '2012-02-02',
                'password' => Hash::make('password'), // Assuming you store hashed passwords
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Michael Johnson',
                'email' => 'michaeljohnson@example.com',
                'phone_number' => '3456789012',
                'date_of_birth' => '1990-03-03',
                'gender' => 'Male',
                'street' => '789 Pine St',
                'city' => 'Anycity',
                'state' => 'Anystate',
                'postal_code' => '34567',
                'country' => 'USA',
                'employee_id' => 'EMP003',
                'date_of_hire' => '2014-03-03',
                'password' => Hash::make('password'), // Assuming you store hashed passwords
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Emily Davis',
                'email' => 'emilydavis@example.com',
                'phone_number' => '4567890123',
                'date_of_birth' => '1995-04-04',
                'gender' => 'Female',
                'street' => '321 Birch St',
                'city' => 'Sometown',
                'state' => 'Somestate',
                'postal_code' => '45678',
                'country' => 'USA',
                'employee_id' => 'EMP004',
                'date_of_hire' => '2016-04-04',
                'password' => Hash::make('password'), // Assuming you store hashed passwords
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'David Wilson',
                'email' => 'davidwilson@example.com',
                'phone_number' => '5678901234',
                'date_of_birth' => '2000-05-05',
                'gender' => 'Male',
                'street' => '654 Cedar St',
                'city' => 'Anothercity',
                'state' => 'Anotherstate',
                'postal_code' => '56789',
                'country' => 'USA',
                'employee_id' => 'EMP005',
                'date_of_hire' => '2018-05-05',
                'password' => Hash::make('password'), // Assuming you store hashed passwords
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
