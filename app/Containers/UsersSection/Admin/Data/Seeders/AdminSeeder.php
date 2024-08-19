<?php
namespace App\Containers\UsersSection\Admin\Data\Seeders;

use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('SecuredKey@2024');

        // Example Users - Ensure these users already exist in the 'users' table
        $users = [
            ['id' => 1, 'name' => 'John Jameson', 'email' => 'johnjameson@admin.com', 'password' => $password, 'role' => 'admin'],
            ['id' => 2, 'name' => 'Angelina Jolie', 'email' => 'angelinajolie@admin.com', 'password' => $password, 'role' => 'admin'],
            // Add more users as needed
        ];

        // Insert users into the 'users' table if they don't already exist
        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],  // Search by email
                [
                    'name' => $user['name'],
                    'password' => $user['password'],  // Ensure password is included
                    'role' => $user['role'],
                ]
            );
        }

        // Administrators data
        $adminstrators = [
            [
                'full_name' => 'John Jameson',
                'email' => 'johnjameson@admin.com',
                'phone_number' => '+1234567890',
                'date_of_birth' => '1980-01-15',
                'gender' => 'Male',
                'street' => '123 Main St',
                'city' => 'Example City',
                'state' => 'Example State',
                'postal_code' => '12345',
                'country' => 'Example Country',
                'profile_picture' => 'profile_pic_url',
                'employee_id' => 'EMP0091',
                'position' => 'head_teacher',
                'department' => 'Education',
                'date_of_hire' => '2020-09-01',
                'employment_type' => 'Full-Time',
                'emergency_contact_name' => 'Jane Doe',
                'emergency_contact_relationship' => 'Spouse',
                'emergency_contact_phone' => '+0987654321',
                'emergency_contact_email' => 'jane.doe@example.com',
                'user_id' => 1, // Assuming this links to the user with ID 32
            ],
            [
                'full_name' => 'Angelina Jolie',
                'email' => 'angelinajolie@admin.com',
                'phone_number' => '+1234567899',
                'date_of_birth' => '1990-06-10',
                'gender' => 'Female',
                'street' => '456 Tech St',
                'city' => 'Tech City',
                'state' => 'Tech State',
                'postal_code' => '67890',
                'country' => 'Tech Country',
                'profile_picture' => 'profile_pic_url',
                'employee_id' => 'EMP002',
                'position' => 'it_officer',
                'department' => 'IT',
                'date_of_hire' => '2021-01-15',
                'employment_type' => 'Part-Time',
                'emergency_contact_name' => 'Bob Smith',
                'emergency_contact_relationship' => 'Brother',
                'emergency_contact_phone' => '+0987654322',
                'emergency_contact_email' => 'bob.smith@example.com',
                'user_id' => 2, // Assuming this links to the user with ID 33
            ],
            // Add more administrators as needed
        ];

        // Insert administrators into the 'administrators' table
        foreach ($adminstrators as $admin) {
            Adminstrator::updateOrCreate(
                ['email' => $admin['email']],  // Search by email
                $admin  // Attributes to update or create
            );
        }
    }
}
